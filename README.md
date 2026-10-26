# SIMAKSI

**Sistem Informasi Monitoring dan Analisis Konflik Satwa Liar Indonesia**

SIMAKSI adalah aplikasi web untuk mendeteksi spesies satwa liar dari foto camera trap menggunakan deep learning, serta memetakan zona konflik manusia-satwa di Pulau Sumatra dengan data tutupan lahan MapBiomas Indonesia.

---

## Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| **Deteksi Satwa** | Upload foto camera trap → deteksi otomatis spesies menggunakan MegaDetector + ResNet-50 |
| **14 Spesies** | Klasifikasi 14 spesies satwa liar Sumatra (harimau, gajah, tapir, beruang madu, dll) |
| **Peta MapBiomas** | Peta interaktif tutupan lahan dari Google Earth Engine (1990–2024) |
| **Zona Konflik** | Visualisasi titik konflik manusia-satwa dengan clustering DBSCAN |
| **Export CSV** | Download data konflik dalam format CSV |
| **Cetak PDF** | Laporan hasil deteksi dalam format print-friendly A4 |
| **Database Spesies** | Profil lengkap 14 spesies: deskripsi, habitat, status konservasi, ancaman |

---

## Arsitektur & Algoritma

```
Foto Camera Trap
       │
       ▼
┌──────────────────┐
│   MegaDetector    │  ← YOLOv5 (Object Detection)
│   "Ada hewan?"    │
└────────┬─────────┘
         ▼
┌──────────────────┐
│    ResNet-50      │  ← CNN Transfer Learning (Image Classification)
│  "Spesies apa?"   │
└────────┬─────────┘
         ▼
   Hasil Deteksi (spesies + confidence)
         │
         ├──► Data Konflik ──► DBSCAN + Haversine (Spatial Clustering)
         │
         └──► GEE/MapBiomas ──► Pixel Classification (Tipe Lahan)
                                       │
                                       ▼
                               Peta Interaktif (Leaflet.js)
```

### Algoritma yang Digunakan

| Algoritma | Kategori | Fungsi |
|-----------|----------|--------|
| **YOLOv5** (MegaDetector) | Object Detection | Deteksi keberadaan hewan di foto |
| **ResNet-50** | Image Classification | Klasifikasi spesies dari crop hewan |
| **DBSCAN** | Spatial Clustering | Pengelompokan titik konflik |
| **GEE Reduce/Remap** | Remote Sensing | Klasifikasi tutupan lahan per titik |

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Frontend** | Blade, Tailwind CSS, Alpine.js, Leaflet.js |
| **Backend** | Laravel 13 (PHP) |
| **Database** | MySQL |
| **AI/ML API** | FastAPI (Python), PyTorch, MegaDetector, ResNet-50 |
| **Geospasial** | Google Earth Engine, MapBiomas Indonesia Collection 4 |
| **Build** | Vite, npm |

---

## Prasyarat

- **PHP** ≥ 8.2
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x + npm
- **MySQL** ≥ 8.0
- **Python** ≥ 3.10 (untuk GEE Service & Detection API)

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Nathan-Algibran/Capstone-Project.git
cd Capstone-Project
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy .env dan isi konfigurasi
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=SIMAKSI
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database

```bash
# Buat database MySQL bernama 'SIMAKSI' terlebih dahulu

# Jalankan migrasi & seeder
php artisan migrate --seed

# Buat symbolic link untuk storage
php artisan storage:link
```

### 5. Jalankan Aplikasi

```bash
# Terminal 1: Build frontend
npm run dev

# Terminal 2: Jalankan server Laravel
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Setup GEE Service (Opsional)

GEE Service diperlukan untuk menampilkan peta tutupan lahan MapBiomas.

### 1. Buat Service Account Google Cloud

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Aktifkan **Earth Engine API**
4. Buat **Service Account** dan download JSON key
5. Daftarkan service account di [EE Registration](https://signup.earthengine.google.com/#!/service_accounts)

### 2. Setup Environment

```bash
cd scripts/gee_service

# Buat virtual environment
python -m venv venv
venv\Scripts\activate        # Windows
# source venv/bin/activate   # Linux/Mac

# Install dependencies
pip install -r requirements.txt

# Copy dan isi .env
cp .env.example .env
```

Edit `scripts/gee_service/.env`:

```env
GEE_PROJECT_ID=your-gcp-project-id
GEE_SERVICE_ACCOUNT_KEY=service-account-key.json
GEE_SERVICE_PORT=8003
```

Simpan file JSON key sebagai `scripts/gee_service/service-account-key.json`.

### 3. Jalankan GEE Service

```bash
# Di folder scripts/gee_service/
uvicorn main:app --port 8003
```

---

## Scripts Utility

| Script | Fungsi | Perintah |
|--------|--------|----------|
| `scripts/cluster_conflicts.py` | DBSCAN clustering titik konflik | `python scripts/cluster_conflicts.py --eps-km 2.0 --min-samples 3` |
| `scripts/classify_habitat.py` | Klasifikasi lahan per titik via GEE | `python scripts/classify_habitat.py --year 2024 --gee-url http://127.0.0.1:8003` |

---

## Struktur Direktori

```
SIMAKSI/
├── app/
│   ├── Http/Controllers/     # Controller (Deteksi, Peta, Satwa, Page)
│   └── Models/                # Eloquent models (Species, Detection, ConflictIncident)
├── database/
│   ├── migrations/            # Skema database
│   └── seeders/               # Data spesies & konflik real
├── resources/
│   └── views/
│       ├── components/        # Blade components (navbar, footer, map, result-card)
│       ├── layouts/           # Layout utama
│       └── pages/             # Halaman (home, deteksi, peta, satwa, tentang, kontak)
├── routes/
│   └── web.php                # Definisi route
├── scripts/
│   ├── gee_service/           # FastAPI service untuk Google Earth Engine
│   │   ├── main.py            # Endpoint tile-url, pixel-class, legend
│   │   ├── requirements.txt
│   │   └── .env.example
│   ├── cluster_conflicts.py   # DBSCAN spatial clustering
│   └── classify_habitat.py    # Land cover classification via GEE
└── public/
    └── images/species/        # Gambar spesies
```

---

## 14 Spesies yang Dideteksi

| No | Spesies | Nama Ilmiah | Status IUCN |
|----|---------|-------------|-------------|
| 1 | Harimau Sumatra | *Panthera tigris sumatrae* | Kritis |
| 2 | Gajah Sumatra | *Elephas maximus sumatranus* | Kritis |
| 3 | Tapir Asia | *Tapirus indicus* | Terancam Punah |
| 4 | Beruang Madu | *Helarctos malayanus* | Rentan |
| 5 | Rusa Sambar | *Rusa unicolor* | Rentan |
| 6 | Babi Hutan | *Sus scrofa* | Risiko Rendah |
| 7 | Kijang Muntjak | *Muntiacus muntjak* | Risiko Rendah |
| 8 | Landak Raya | *Hystrix brachyura* | Risiko Rendah |
| 9 | Beruk | *Macaca nemestrina* | Rentan |
| 10 | Monyet Ekor Panjang | *Macaca fascicularis* | Terancam Punah |
| 11 | Kuau Raja | *Argusianus argus* | Hampir Terancam |
| 12 | Kambing Hutan Sumatra | *Capricornis sumatraensis* | Rentan |
| 13 | Musang Leher Kuning | *Martes flavigula* | Risiko Rendah |
| 14 | Musang Akar | *Paguma larvata* | Risiko Rendah |

---

## Sumber Data Konflik

Data konflik manusia-satwa liar dihimpun dari:
- **BKSDA** (Balai Konservasi Sumber Daya Alam) seluruh provinsi Sumatra
- **KLHK** (Kementerian Lingkungan Hidup dan Kehutanan)
- **Balai Taman Nasional** (Way Kambas, Kerinci Seblat, Bukit Barisan Selatan)
- **Mongabay Indonesia**, CNN Indonesia, Kompas, Detik
- **WWF Indonesia**, HAkA (Hutan, Alam dan Lingkungan Aceh)

Total: **87 insiden** tercatat (2015–2026)

---

## Lisensi

Proyek Capstone — Semester 5

---

*Dibuat dengan ❤️ untuk konservasi satwa liar Sumatra*
