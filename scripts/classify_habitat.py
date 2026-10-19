"""
SIMAKSI — Classify Detection & Conflict Points
=================================================
Script untuk mengklasifikasi titik deteksi dan konflik
berdasarkan kelas land cover MapBiomas via GEE Service.

Usage:
    python classify_habitat.py [--year 2022] [--gee-url http://127.0.0.1:8002]

Prasyarat:
    - GEE Service sudah jalan (uvicorn main:app --port 8002)
    - Database MySQL SIMAKSI sudah terisi data deteksi/konflik
    - pip install requests pymysql python-dotenv
"""

import argparse
import os
import sys
import time

import requests
import pymysql
from dotenv import load_dotenv

# Load .env dari root project
ROOT_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
load_dotenv(os.path.join(ROOT_DIR, ".env"))

DB_CONFIG = {
    "host": os.getenv("DB_HOST", "127.0.0.1"),
    "port": int(os.getenv("DB_PORT", 3306)),
    "user": os.getenv("DB_USERNAME", "root"),
    "password": os.getenv("DB_PASSWORD", ""),
    "database": os.getenv("DB_DATABASE", "SIMAKSI"),
    "charset": "utf8mb4",
}


def get_pixel_class(gee_url: str, lat: float, lng: float, year: int) -> dict:
    """Ambil kelas land cover dari GEE service."""
    resp = requests.get(
        f"{gee_url}/pixel-class",
        params={"lat": lat, "lng": lng, "year": year},
        timeout=30,
    )
    resp.raise_for_status()
    return resp.json()


def classify_table(conn, table: str, gee_url: str, fallback_year: int):
    """Klasifikasi semua baris di tabel yang belum punya land_class_id.
    
    Untuk conflict_incidents: gunakan tahun dari kolom 'tanggal' agar
    sesuai dengan data MapBiomas tahun tersebut. Jika tahun > 2024
    (belum tersedia di Collection 4), fallback ke 2024.
    Untuk detections: gunakan fallback_year.
    """
    MAX_MAPBIOMAS_YEAR = 2024
    MIN_MAPBIOMAS_YEAR = 1990

    with conn.cursor() as cur:
        if table == "conflict_incidents":
            cur.execute(
                f"SELECT id, lokasi_lat, lokasi_lng, YEAR(tanggal) as tahun FROM {table} "
                f"WHERE lokasi_lat IS NOT NULL AND lokasi_lng IS NOT NULL "
                f"AND land_class_id IS NULL"
            )
        else:
            cur.execute(
                f"SELECT id, lokasi_lat, lokasi_lng, NULL as tahun FROM {table} "
                f"WHERE lokasi_lat IS NOT NULL AND lokasi_lng IS NOT NULL "
                f"AND land_class_id IS NULL"
            )
        rows = cur.fetchall()

    total = len(rows)
    if total == 0:
        print(f"  [{table}] Semua data sudah terklasifikasi.")
        return

    print(f"  [{table}] {total} baris perlu diklasifikasi...")

    for i, (row_id, lat, lng, tahun_insiden) in enumerate(rows, 1):
        try:
            # Tentukan tahun MapBiomas yang sesuai
            if tahun_insiden and MIN_MAPBIOMAS_YEAR <= tahun_insiden <= MAX_MAPBIOMAS_YEAR:
                year = tahun_insiden
            elif tahun_insiden and tahun_insiden > MAX_MAPBIOMAS_YEAR:
                year = MAX_MAPBIOMAS_YEAR  # fallback ke tahun terakhir
            else:
                year = fallback_year

            result = get_pixel_class(gee_url, float(lat), float(lng), year)
            class_id = result.get("class_id")
            label = result.get("label", "Tidak Diketahui")
            tipe = result.get("tipe", "unknown")

            with conn.cursor() as cur:
                if table == "detections":
                    cur.execute(
                        f"UPDATE {table} SET land_class_id=%s, land_class_label=%s, tipe=%s WHERE id=%s",
                        (class_id, label, tipe, row_id),
                    )
                else:
                    cur.execute(
                        f"UPDATE {table} SET land_class_id=%s, land_class_label=%s WHERE id=%s",
                        (class_id, label, row_id),
                    )
            conn.commit()

            year_note = f"(mapbiomas {year})" if tahun_insiden else ""
            status = f"class={class_id} ({label}) -> {tipe}"
            print(f"    [{i}/{total}] id={row_id} lat={lat} lng={lng} {year_note} -> {status}")

            # Rate limit agar tidak membebani GEE
            time.sleep(0.5)

        except Exception as e:
            print(f"    [{i}/{total}] id={row_id} GAGAL: {e}")

    print(f"  [{table}] Selesai.")


def main():
    parser = argparse.ArgumentParser(description="Classify detection/conflict points via MapBiomas GEE")
    parser.add_argument("--year", type=int, default=2022, help="Tahun data MapBiomas")
    parser.add_argument("--gee-url", default="http://127.0.0.1:8002", help="URL GEE service")
    args = parser.parse_args()

    print(f"=== SIMAKSI Habitat Classifier ===")
    print(f"Tahun: {args.year}")
    print(f"GEE Service: {args.gee_url}")
    print(f"Database: {DB_CONFIG['database']}@{DB_CONFIG['host']}")
    print()

    # Test koneksi GEE
    try:
        resp = requests.get(f"{args.gee_url}/", timeout=5)
        resp.raise_for_status()
        print("GEE Service: OK")
    except Exception as e:
        print(f"GAGAL terhubung ke GEE Service: {e}")
        sys.exit(1)

    # Koneksi DB
    conn = pymysql.connect(**DB_CONFIG)
    print("Database: OK")
    print()

    try:
        print("1. Klasifikasi tabel detections...")
        classify_table(conn, "detections", args.gee_url, args.year)
        print()

        print("2. Klasifikasi tabel conflict_incidents...")
        classify_table(conn, "conflict_incidents", args.gee_url, args.year)
        print()

        print("=== SELESAI ===")
    finally:
        conn.close()


if __name__ == "__main__":
    main()
