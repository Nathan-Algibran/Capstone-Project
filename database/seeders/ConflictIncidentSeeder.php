<?php

namespace Database\Seeders;

use App\Models\ConflictIncident;
use App\Models\Species;
use Illuminate\Database\Seeder;

class ConflictIncidentSeeder extends Seeder
{
    public function run(): void
    {
        // Data dummy konflik manusia-satwa di berbagai lokasi Sumatra
        $incidents = [
            // Gajah Sumatra — konflik paling sering terjadi
            ['species_slug' => 'gajah-sumatra', 'lat' => 3.5896, 'lng' => 98.2192, 'nama' => 'Langkat, Sumatra Utara', 'tanggal' => '2025-03-15', 'sumber' => 'BKSDA Sumut', 'deskripsi' => 'Kawanan gajah memasuki area perkebunan kelapa sawit dan merusak tanaman warga.'],
            ['species_slug' => 'gajah-sumatra', 'lat' => 2.9845, 'lng' => 99.0489, 'nama' => 'Simalungun, Sumatra Utara', 'tanggal' => '2025-05-22', 'sumber' => 'BKSDA Sumut', 'deskripsi' => 'Seekor gajah soliter ditemukan di area persawahan, menginjak tanaman padi.'],
            ['species_slug' => 'gajah-sumatra', 'lat' => -1.6101, 'lng' => 103.6131, 'nama' => 'Tebo, Jambi', 'tanggal' => '2025-07-10', 'sumber' => 'BKSDA Jambi', 'deskripsi' => 'Konflik gajah-manusia di perbatasan Taman Nasional Bukit Tigapuluh.'],
            ['species_slug' => 'gajah-sumatra', 'lat' => -0.5063, 'lng' => 101.4458, 'nama' => 'Pelalawan, Riau', 'tanggal' => '2025-01-08', 'sumber' => 'WWF Riau', 'deskripsi' => 'Kawanan gajah 12 ekor melintas area perkebunan akasia.'],
            ['species_slug' => 'gajah-sumatra', 'lat' => -4.5586, 'lng' => 104.7754, 'nama' => 'Way Kambas, Lampung', 'tanggal' => '2025-08-03', 'sumber' => 'TNWK', 'deskripsi' => 'Gajah keluar dari kawasan taman nasional menuju ladang jagung.'],

            // Harimau Sumatra
            ['species_slug' => 'harimau-sumatra', 'lat' => 0.6571, 'lng' => 101.7161, 'nama' => 'Kampar, Riau', 'tanggal' => '2025-02-20', 'sumber' => 'BKSDA Riau', 'deskripsi' => 'Harimau memangsa ternak sapi milik warga di tepi hutan.'],
            ['species_slug' => 'harimau-sumatra', 'lat' => -1.1326, 'lng' => 101.6827, 'nama' => 'Kuantan Singingi, Riau', 'tanggal' => '2025-04-14', 'sumber' => 'BKSDA Riau', 'deskripsi' => 'Jejak harimau ditemukan di kebun karet warga, ternak kambing hilang.'],
            ['species_slug' => 'harimau-sumatra', 'lat' => -2.5045, 'lng' => 101.5434, 'nama' => 'Merangin, Jambi', 'tanggal' => '2025-06-30', 'sumber' => 'BKSDA Jambi', 'deskripsi' => 'Harimau terlihat warga di pinggir jalan dekat perkebunan.'],
            ['species_slug' => 'harimau-sumatra', 'lat' => -3.7895, 'lng' => 102.2601, 'nama' => 'Kerinci, Jambi', 'tanggal' => '2025-09-11', 'sumber' => 'TNKS', 'deskripsi' => 'Laporan warga tentang harimau di sekitar area pertanian dekat TNKS.'],

            // Orangutan Sumatra
            ['species_slug' => 'orangutan-sumatra', 'lat' => 3.5133, 'lng' => 98.1167, 'nama' => 'Batang Toru, Sumatra Utara', 'tanggal' => '2025-04-05', 'sumber' => 'YOI', 'deskripsi' => 'Orangutan memasuki kebun durian warga di pinggir hutan.'],
            ['species_slug' => 'orangutan-sumatra', 'lat' => 3.7523, 'lng' => 97.5667, 'nama' => 'Leuser, Aceh', 'tanggal' => '2025-06-18', 'sumber' => 'BKSDA Aceh', 'deskripsi' => 'Orangutan terluka akibat jerat yang dipasang untuk babi hutan.'],

            // Tapir Asia
            ['species_slug' => 'tapir-asia', 'lat' => -0.3214, 'lng' => 100.3673, 'nama' => 'Solok, Sumatra Barat', 'tanggal' => '2025-03-28', 'sumber' => 'BKSDA Sumbar', 'deskripsi' => 'Tapir ditemukan terluka di pinggir jalan lintas Sumatra.'],
            ['species_slug' => 'tapir-asia', 'lat' => -1.7523, 'lng' => 101.3845, 'nama' => 'Bungo, Jambi', 'tanggal' => '2025-08-15', 'sumber' => 'BKSDA Jambi', 'deskripsi' => 'Tapir tertangkap kamera warga di area perkebunan karet.'],

            // Beruang Madu
            ['species_slug' => 'beruang-madu', 'lat' => 2.9576, 'lng' => 99.0551, 'nama' => 'Tapanuli, Sumatra Utara', 'tanggal' => '2025-05-10', 'sumber' => 'BKSDA Sumut', 'deskripsi' => 'Beruang madu merusak sarang lebah milik peternak madu.'],
            ['species_slug' => 'beruang-madu', 'lat' => -2.3321, 'lng' => 101.1567, 'nama' => 'Sarolangun, Jambi', 'tanggal' => '2025-07-22', 'sumber' => 'BKSDA Jambi', 'deskripsi' => 'Beruang madu masuk ke kampung mencari makanan.'],

            // Babi Hutan
            ['species_slug' => 'babi-hutan', 'lat' => 0.5069, 'lng' => 101.4478, 'nama' => 'Pekanbaru, Riau', 'tanggal' => '2025-01-25', 'sumber' => 'Dinas Pertanian Riau', 'deskripsi' => 'Kawanan babi hutan merusak ladang jagung dan singkong.'],
            ['species_slug' => 'babi-hutan', 'lat' => -3.3194, 'lng' => 104.9144, 'nama' => 'Muara Enim, Sumsel', 'tanggal' => '2025-04-30', 'sumber' => 'BKSDA Sumsel', 'deskripsi' => 'Serangan babi hutan ke area pertanian warga transmigrasi.'],
            ['species_slug' => 'babi-hutan', 'lat' => -4.9558, 'lng' => 104.1059, 'nama' => 'Tanggamus, Lampung', 'tanggal' => '2025-06-12', 'sumber' => 'BKSDA Lampung', 'deskripsi' => 'Keluhan warga tentang babi hutan yang merusak kebun kopi.'],

            // Macan Dahan
            ['species_slug' => 'macan-dahan', 'lat' => -1.5989, 'lng' => 101.2515, 'nama' => 'Kerinci Seblat', 'tanggal' => '2025-09-01', 'sumber' => 'TNKS', 'deskripsi' => 'Macan dahan memangsa ayam ternak di pemukiman dekat taman nasional.'],
        ];

        foreach ($incidents as $data) {
            $species = Species::where('slug', $data['species_slug'])->first();

            if ($species) {
                ConflictIncident::create([
                    'species_id' => $species->id,
                    'lokasi_lat' => $data['lat'],
                    'lokasi_lng' => $data['lng'],
                    'lokasi_nama' => $data['nama'],
                    'tanggal' => $data['tanggal'],
                    'sumber' => $data['sumber'],
                    'deskripsi' => $data['deskripsi'],
                ]);
            }
        }
    }
}
