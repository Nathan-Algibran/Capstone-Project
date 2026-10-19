"""
SIMAKSI — GEE MapBiomas Tile Service
=====================================
FastAPI microservice yang meng-autentikasi ke Google Earth Engine,
mengambil data MapBiomas Indonesia land cover, dan menyajikan
tile URL dinamis untuk dipakai oleh Leaflet di frontend Laravel.

Jalankan:
    cd scripts/gee_service
    pip install -r requirements.txt
    uvicorn main:app --port 8003 --reload
"""

import os
import time
import logging
from typing import Optional

import ee
from google.oauth2 import service_account
from fastapi import FastAPI, HTTPException, Query
from fastapi.middleware.cors import CORSMiddleware
from dotenv import load_dotenv

load_dotenv()

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("gee_service")

# ---------------------------------------------------------------------------
# Konfigurasi
# ---------------------------------------------------------------------------

GEE_PROJECT_ID = os.getenv("GEE_PROJECT_ID", "")
GEE_KEY_FILE = os.getenv("GEE_SERVICE_ACCOUNT_KEY", "service-account-key.json")

# Asset ID resmi MapBiomas Indonesia Collection 4
MAPBIOMAS_ASSET = (
    "projects/mapbiomas-public/assets/indonesia/"
    "lulc/collection4/mapbiomas_indonesia_collection4_coverage_v2"
)

# Bounding box Sumatra (approx)
SUMATRA_BOUNDS = [95.0, -6.0, 109.0, 6.0]

# ---------------------------------------------------------------------------
# Legenda kelas MapBiomas Indonesia
# ---------------------------------------------------------------------------

MAPBIOMAS_CLASSES = {
    3:  {"label": "Formasi Hutan",               "color": "#1f8d49", "tipe": "habitat"},
    4:  {"label": "Formasi Savana",               "color": "#7dc975", "tipe": "habitat"},
    5:  {"label": "Mangrove",                     "color": "#04381d", "tipe": "habitat"},
    9:  {"label": "Hutan Tanaman (HTI)",          "color": "#7a5900", "tipe": "konflik"},
    11: {"label": "Lahan Basah",                  "color": "#519799", "tipe": "habitat"},
    12: {"label": "Padang Rumput",                "color": "#d6bc74", "tipe": "habitat"},
    15: {"label": "Padang Penggembalaan",         "color": "#edde8e", "tipe": "konflik"},
    21: {"label": "Mosaik Pertanian & Padang",    "color": "#ffefc3", "tipe": "konflik"},
    23: {"label": "Pantai & Gumuk Pasir",         "color": "#ffa07a", "tipe": "habitat"},
    24: {"label": "Area Perkotaan",               "color": "#d4271e", "tipe": "konflik"},
    25: {"label": "Area Non-Vegetasi Lainnya",    "color": "#db4d4f", "tipe": "konflik"},
    27: {"label": "Tidak Terobservasi",           "color": "#ffffff", "tipe": "unknown"},
    29: {"label": "Singkapan Batuan",             "color": "#8c8c8c", "tipe": "habitat"},
    30: {"label": "Pertambangan",                 "color": "#9c0027", "tipe": "konflik"},
    33: {"label": "Badan Air",                    "color": "#2532e4", "tipe": "habitat"},
    35: {"label": "Kelapa Sawit",                 "color": "#c71585", "tipe": "konflik"},
    36: {"label": "Tanaman Tahunan",              "color": "#d082de", "tipe": "konflik"},
    40: {"label": "Padi",                         "color": "#982c9e", "tipe": "konflik"},
    41: {"label": "Tanaman Semusim Lainnya",      "color": "#e787f8", "tipe": "konflik"},
    46: {"label": "Kopi",                         "color": "#cca0d4", "tipe": "konflik"},
    48: {"label": "Tanaman Tahunan Lainnya",      "color": "#cd49e4", "tipe": "konflik"},
}

# ---------------------------------------------------------------------------
# Inisialisasi Earth Engine
# ---------------------------------------------------------------------------

_ee_initialized = False


def init_ee():
    """Inisialisasi Earth Engine dengan service account."""
    global _ee_initialized
    if _ee_initialized:
        return

    key_path = os.path.join(os.path.dirname(__file__), GEE_KEY_FILE)

    if not os.path.exists(key_path):
        raise RuntimeError(
            f"Service account key tidak ditemukan: {key_path}\n"
            "Buat service account di Google Cloud Console, aktifkan Earth Engine API,\n"
            "download JSON key, dan simpan sebagai 'service-account-key.json' di folder ini."
        )

    credentials = service_account.Credentials.from_service_account_file(
        key_path,
        scopes=["https://www.googleapis.com/auth/earthengine"],
    )

    ee.Initialize(
        credentials=credentials,
        project=GEE_PROJECT_ID,
    )
    _ee_initialized = True
    logger.info("Earth Engine berhasil diinisialisasi (project: %s)", GEE_PROJECT_ID)


# ---------------------------------------------------------------------------
# Cache tile URL (kedaluwarsa setelah ~1 jam)
# ---------------------------------------------------------------------------

_tile_cache: dict = {}  # key: year -> {"url": ..., "expires": timestamp}
CACHE_TTL = 3600  # 1 jam


def _get_cached_tile_url(year: int) -> Optional[str]:
    """Ambil tile URL dari cache jika masih valid."""
    entry = _tile_cache.get(year)
    if entry and entry["expires"] > time.time():
        return entry["url"]
    return None


def _set_cached_tile_url(year: int, url: str):
    """Simpan tile URL ke cache."""
    _tile_cache[year] = {
        "url": url,
        "expires": time.time() + CACHE_TTL,
    }


# ---------------------------------------------------------------------------
# Fungsi GEE
# ---------------------------------------------------------------------------

def get_mapbiomas_tile_url(year: int) -> str:
    """
    Generate tile URL untuk MapBiomas Indonesia land cover via GEE.
    Tile URL bisa langsung dipakai oleh Leaflet L.tileLayer().
    """
    cached = _get_cached_tile_url(year)
    if cached:
        logger.info("Cache hit untuk tahun %d", year)
        return cached

    init_ee()

    mapbiomas = ee.Image(MAPBIOMAS_ASSET)

    # Pilih band tahun yang diminta
    band_name = f"classification_{year}"
    try:
        classification = mapbiomas.select(band_name)
    except Exception:
        raise HTTPException(
            status_code=400,
            detail=f"Band '{band_name}' tidak tersedia. Coba tahun lain.",
        )

    # Clip ke Sumatra
    sumatra_geom = ee.Geometry.Rectangle(SUMATRA_BOUNDS)
    clipped = classification.clip(sumatra_geom)

    # Remap kelas ke sequential untuk visualisasi palette
    class_values = sorted(MAPBIOMAS_CLASSES.keys())
    class_colors = [MAPBIOMAS_CLASSES[v]["color"] for v in class_values]
    sequential = list(range(len(class_values)))

    remapped = clipped.remap(class_values, sequential).toUint8()

    vis_params = {
        "min": 0,
        "max": len(class_values) - 1,
        "palette": class_colors,
    }

    map_id_dict = remapped.getMapId(vis_params)
    tile_url = map_id_dict["tile_fetcher"].url_format

    _set_cached_tile_url(year, tile_url)
    logger.info("Tile URL berhasil di-generate untuk tahun %d", year)

    return tile_url


def get_pixel_class(lat: float, lng: float, year: int) -> Optional[dict]:
    """
    Ambil kelas land cover di satu titik koordinat.
    Return dict {"class_id": int, "label": str, "tipe": str} atau None.
    """
    init_ee()

    mapbiomas = ee.Image(MAPBIOMAS_ASSET)
    band_name = f"classification_{year}"
    classification = mapbiomas.select(band_name)

    point = ee.Geometry.Point([lng, lat])
    result = classification.reduceRegion(
        reducer=ee.Reducer.first(),
        geometry=point,
        scale=30,
    ).getInfo()

    class_id = result.get(band_name)
    if class_id is None:
        return None

    class_id = int(class_id)
    class_info = MAPBIOMAS_CLASSES.get(class_id)

    if class_info is None:
        return {"class_id": class_id, "label": "Tidak Diketahui", "tipe": "unknown"}

    return {
        "class_id": class_id,
        "label": class_info["label"],
        "color": class_info["color"],
        "tipe": class_info["tipe"],
    }


# ---------------------------------------------------------------------------
# FastAPI App
# ---------------------------------------------------------------------------

app = FastAPI(
    title="SIMAKSI GEE Service",
    description="Microservice untuk mengambil data MapBiomas Indonesia via Google Earth Engine",
    version="2.0.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/")
def root():
    return {
        "service": "SIMAKSI GEE Service",
        "status": "running",
        "asset": MAPBIOMAS_ASSET,
        "endpoints": ["/tile-url", "/pixel-class", "/legend", "/available-years"],
    }


@app.get("/tile-url")
def tile_url_endpoint(year: int = Query(default=2024, ge=1990, le=2024)):
    """
    Dapatkan tile URL MapBiomas untuk tahun tertentu.
    URL ini bisa langsung dipakai di Leaflet L.tileLayer().
    """
    try:
        url = get_mapbiomas_tile_url(year)
        return {
            "tile_url": url,
            "year": year,
            "attribution": "MapBiomas Indonesia Collection 4",
            "bounds": SUMATRA_BOUNDS,
            "opacity_recommended": 0.7,
        }
    except HTTPException:
        raise
    except Exception as e:
        logger.error("Gagal generate tile URL: %s", str(e))
        raise HTTPException(status_code=500, detail=f"Gagal mengambil tile: {str(e)}")


@app.get("/pixel-class")
def pixel_class_endpoint(
    lat: float = Query(..., ge=-10.0, le=10.0),
    lng: float = Query(..., ge=90.0, le=115.0),
    year: int = Query(default=2024, ge=1990, le=2024),
):
    """
    Ambil kelas land cover di satu titik koordinat.
    Dipakai untuk mengklasifikasi titik deteksi sebagai habitat/konflik.
    """
    try:
        result = get_pixel_class(lat, lng, year)
        if result is None:
            return {"class_id": None, "label": "Di luar cakupan", "tipe": "unknown"}
        return result
    except Exception as e:
        logger.error("Gagal ambil pixel class: %s", str(e))
        raise HTTPException(status_code=500, detail=f"Gagal: {str(e)}")


@app.get("/pixel-class-batch")
def pixel_class_batch_endpoint(
    coords: str = Query(
        ...,
        description="Koordinat dalam format 'lat1,lng1;lat2,lng2;...' (max 50 titik)",
    ),
    year: int = Query(default=2024, ge=1990, le=2024),
):
    """
    Batch lookup kelas land cover untuk banyak titik sekaligus.
    Format coords: 'lat1,lng1;lat2,lng2;...'
    """
    try:
        pairs = coords.split(";")
        if len(pairs) > 50:
            raise HTTPException(status_code=400, detail="Maksimal 50 titik per request")

        results = []
        for pair in pairs:
            parts = pair.strip().split(",")
            if len(parts) != 2:
                results.append({"error": f"Format salah: {pair}"})
                continue
            lat, lng = float(parts[0]), float(parts[1])
            result = get_pixel_class(lat, lng, year)
            results.append({"lat": lat, "lng": lng, **(result or {"class_id": None, "tipe": "unknown"})})

        return {"results": results, "year": year}
    except HTTPException:
        raise
    except Exception as e:
        logger.error("Gagal batch lookup: %s", str(e))
        raise HTTPException(status_code=500, detail=f"Gagal: {str(e)}")


@app.get("/legend")
def legend_endpoint():
    """Kembalikan legenda warna kelas MapBiomas Indonesia."""
    legend = []
    for class_id in sorted(MAPBIOMAS_CLASSES.keys()):
        info = MAPBIOMAS_CLASSES[class_id]
        legend.append({
            "class_id": class_id,
            "label": info["label"],
            "color": info["color"],
            "tipe": info["tipe"],
        })
    return {"legend": legend}


@app.get("/available-years")
def available_years_endpoint():
    """Daftar tahun yang tersedia di MapBiomas Indonesia Collection 4."""
    return {
        "years": list(range(1990, 2025)),
        "recommended": 2024,
        "collection": "MapBiomas Indonesia Collection 4",
    }


# ---------------------------------------------------------------------------
# Entry point
# ---------------------------------------------------------------------------

if __name__ == "__main__":
    import uvicorn

    port = int(os.getenv("GEE_SERVICE_PORT", 8003))
    uvicorn.run("main:app", host="0.0.0.0", port=port, reload=True)
