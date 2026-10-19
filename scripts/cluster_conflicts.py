"""
SIMAKSI — DBSCAN Clustering for Conflict Points
=================================================
Script untuk mengelompokkan titik-titik konflik manusia-satwa liar
menggunakan DBSCAN clustering. Hasilnya disimpan ke kolom cluster_id
di tabel conflict_incidents.

Usage:
    python cluster_conflicts.py [--eps-km 2.0] [--min-samples 3]

Prasyarat:
    - pip install scikit-learn pymysql numpy python-dotenv
    - Database MySQL SIMAKSI sudah terisi data konflik
"""

import argparse
import os

import numpy as np
import pymysql
from sklearn.cluster import DBSCAN
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

# Radius bumi dalam kilometer
EARTH_RADIUS_KM = 6371.0


def main():
    parser = argparse.ArgumentParser(description="DBSCAN clustering untuk titik konflik")
    parser.add_argument(
        "--eps-km",
        type=float,
        default=2.0,
        help="Jarak maksimum antar titik dalam satu cluster (km). Default: 2.0",
    )
    parser.add_argument(
        "--min-samples",
        type=int,
        default=3,
        help="Jumlah minimum titik untuk membentuk cluster. Default: 3",
    )
    args = parser.parse_args()

    print("=== SIMAKSI Conflict Clustering (DBSCAN) ===")
    print(f"Eps: {args.eps_km} km")
    print(f"Min samples: {args.min_samples}")
    print(f"Database: {DB_CONFIG['database']}@{DB_CONFIG['host']}")
    print()

    conn = pymysql.connect(**DB_CONFIG)

    try:
        # Ambil semua titik konflik dengan koordinat
        with conn.cursor() as cur:
            cur.execute(
                "SELECT id, lokasi_lat, lokasi_lng FROM conflict_incidents "
                "WHERE lokasi_lat IS NOT NULL AND lokasi_lng IS NOT NULL"
            )
            rows = cur.fetchall()

        if not rows:
            print("Tidak ada data konflik dengan koordinat.")
            return

        ids = [r[0] for r in rows]
        coords = np.array([[float(r[1]), float(r[2])] for r in rows])

        print(f"Total titik konflik: {len(ids)}")

        # Konversi ke radian untuk haversine
        coords_rad = np.radians(coords)

        # Konversi eps dari km ke radian
        eps_rad = args.eps_km / EARTH_RADIUS_KM

        # Jalankan DBSCAN dengan metric haversine
        clustering = DBSCAN(
            eps=eps_rad,
            min_samples=args.min_samples,
            metric="haversine",
        )
        labels = clustering.fit_predict(coords_rad)

        # Hitung statistik
        n_clusters = len(set(labels)) - (1 if -1 in labels else 0)
        n_noise = list(labels).count(-1)

        print(f"Cluster ditemukan: {n_clusters}")
        print(f"Titik noise (tidak terkluster): {n_noise}")
        print()

        # Update database
        print("Menyimpan hasil ke database...")
        with conn.cursor() as cur:
            for row_id, cluster_id in zip(ids, labels):
                cur.execute(
                    "UPDATE conflict_incidents SET cluster_id = %s WHERE id = %s",
                    (int(cluster_id), row_id),
                )
        conn.commit()

        # Tampilkan ringkasan per cluster
        for c_id in sorted(set(labels)):
            if c_id == -1:
                continue
            mask = labels == c_id
            cluster_coords = coords[mask]
            center_lat = cluster_coords[:, 0].mean()
            center_lng = cluster_coords[:, 1].mean()
            print(
                f"  Cluster {c_id}: {mask.sum()} titik, "
                f"pusat ({center_lat:.4f}, {center_lng:.4f})"
            )

        if n_noise > 0:
            print(f"  Noise: {n_noise} titik (cluster_id = -1)")

        print()
        print("=== SELESAI ===")

    finally:
        conn.close()


if __name__ == "__main__":
    main()
