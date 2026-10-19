# SIMAKSI GEE Service — Setup Guide

Microservice Python (FastAPI) untuk menyajikan tile MapBiomas Indonesia
via Google Earth Engine secara dinamis ke peta Leaflet di SIMAKSI.

---

## Prasyarat

1. **Python 3.9+** terinstall
2. **Akun Google Cloud** dengan project aktif
3. **Google Earth Engine** terdaftar pada project tersebut

---

## Langkah Setup

### 1. Buat Google Cloud Project & Aktifkan Earth Engine

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru (atau pakai yang sudah ada)
3. Buka [Google Earth Engine](https://code.earthengine.google.com/) dan daftar dengan project tersebut
4. Atau daftar via: https://signup.earthengine.google.com/
5. Aktifkan **Earth Engine API** di Cloud Console:
   - Menu > APIs & Services > Library > cari "Earth Engine API" > Enable

### 2. Buat Service Account

1. Di Cloud Console, buka **IAM & Admin > Service Accounts**
2. Klik **Create Service Account**
   - Nama: `simaksi-gee` (atau bebas)
   - Role: skip (tidak perlu role khusus)
3. Buka service account yang baru dibuat
4. Tab **Keys > Add Key > Create new key > JSON**
5. Download file JSON key
6. **Simpan** file tersebut di folder ini sebagai `service-account-key.json`

### 3. Daftarkan Service Account ke Earth Engine

1. Buka https://code.earthengine.google.com/
2. Klik ikon profil > **Settings**
3. Pada **Manage Cloud Project**, pastikan project kamu terdaftar
4. **Atau** jalankan di terminal:
   ```
   earthengine authenticate --service-account-key=service-account-key.json
   ```

### 4. Install Dependencies & Jalankan

```bash
cd scripts/gee_service

# Buat virtual environment (opsional tapi disarankan)
python -m venv venv
venv\Scripts\activate       # Windows
# source venv/bin/activate  # Mac/Linux

# Install dependencies
pip install -r requirements.txt

# Copy dan isi file konfigurasi
copy .env.example .env
# Edit .env — isi GEE_PROJECT_ID dengan project ID kamu

# Jalankan service
uvicorn main:app --port 8002 --reload
```

### 5. Test

Buka browser ke:
- http://127.0.0.1:8002/ — status service
- http://127.0.0.1:8002/legend — legenda kelas MapBiomas
- http://127.0.0.1:8002/tile-url?year=2022 — ambil tile URL
- http://127.0.0.1:8002/docs — Swagger API docs (auto-generated)

---

## Endpoints

| Endpoint | Deskripsi |
|----------|-----------|
| `GET /` | Status service |
| `GET /tile-url?year=2022` | Tile URL MapBiomas untuk Leaflet |
| `GET /pixel-class?lat=-2.5&lng=102.3&year=2022` | Kelas land cover di titik |
| `GET /pixel-class-batch?coords=lat1,lng1;lat2,lng2&year=2022` | Batch lookup (max 50) |
| `GET /legend` | Legenda warna kelas MapBiomas |
| `GET /available-years` | Daftar tahun tersedia |

---

## Cara Pakai dengan SIMAKSI

Setelah service jalan di port 8002:

1. Pastikan file `.env` di root SIMAKSI punya:
   ```
   GEE_API_URL=http://127.0.0.1:8002
   ```

2. Buka halaman **Peta Biomassa** (`/peta-biomassa`) — overlay MapBiomas akan muncul otomatis

3. (Opsional) Jalankan script klasifikasi habitat:
   ```bash
   cd scripts
   pip install requests pymysql python-dotenv
   python classify_habitat.py --year 2022
   ```

4. (Opsional) Jalankan script clustering DBSCAN:
   ```bash
   pip install scikit-learn pymysql numpy python-dotenv
   python cluster_conflicts.py --eps-km 2.0 --min-samples 3
   ```

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| "Service account key tidak ditemukan" | Pastikan `service-account-key.json` ada di folder `scripts/gee_service/` |
| "Earth Engine API has not been used in project" | Aktifkan Earth Engine API di Cloud Console |
| "User is not registered" | Daftarkan project di https://signup.earthengine.google.com/ |
| Tile URL error 403 | Token expired, restart service untuk refresh cache |
| Laravel tidak menampilkan overlay | Cek apakah GEE service jalan (`curl http://127.0.0.1:8002/`) |
