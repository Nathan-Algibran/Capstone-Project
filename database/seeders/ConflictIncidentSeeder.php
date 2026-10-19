<?php

namespace Database\Seeders;

use App\Models\ConflictIncident;
use App\Models\Species;
use Illuminate\Database\Seeder;

class ConflictIncidentSeeder extends Seeder
{
    public function run(): void
    {
        // =================================================================
        // DATA REAL — dihimpun dari laporan BKSDA, Mongabay Indonesia,
        // CNN Indonesia, Kompas, Detik, KLHK, dan media konservasi.
        // Koordinat geocoded dari nama desa/kecamatan resmi via
        // Wikipedia/BPS/GeoView.
        // =================================================================

        $incidents = [

            // =============================================================
            // HARIMAU SUMATRA (Panthera tigris sumatrae)
            // =============================================================
            ['species_slug'=>'harimau-sumatra','lat'=>-3.1925,'lng'=>101.8692,'nama'=>'Desa Kinal Jaya, Kec. Napal Putih, Kab. Bengkulu Utara','tanggal'=>'2024-11-20','sumber'=>'Mongabay Indonesia / BKSDA Bengkulu','deskripsi'=>'Enam harimau (termasuk induk dan anak) terekam kamera warga di belakang rumah.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-5.3603,'lng'=>104.7781,'nama'=>'Pekon Sinar Harapan, Kec. Bandar Negeri Suoh, Kab. Lampung Barat','tanggal'=>'2024-08-14','sumber'=>'BKSDA Lampung / Balai TNBBS','deskripsi'=>'Konflik harimau-manusia di sekitar TN Bukit Barisan Selatan. Tercatat 8 konflik harimau di 2024.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-0.1658,'lng'=>100.3042,'nama'=>'Nagari Pasia Laweh, Kec. Palupuh, Kab. Agam, Sumbar','tanggal'=>'2024-07-15','sumber'=>'BKSDA Sumbar / CNN Indonesia','deskripsi'=>'Harimau betina memangsa kambing ternak dan berkeliaran dekat sekolah. Dievakuasi dengan kandang jebak.'],
            ['species_slug'=>'harimau-sumatra','lat'=>0.1994,'lng'=>100.0561,'nama'=>'Kab. Pasaman, Sumbar','tanggal'=>'2024-05-03','sumber'=>'BKSDA Sumbar','deskripsi'=>'Harimau memangsa ternak sapi di perkebunan yang berbatasan dengan hutan lindung.'],
            ['species_slug'=>'harimau-sumatra','lat'=>3.2167,'lng'=>97.3833,'nama'=>'Hutan Sampali, Kec. Kluet Tengah, Kab. Aceh Selatan','tanggal'=>'2023-02-10','sumber'=>'Mongabay Indonesia','deskripsi'=>'Konflik harimau dengan petani di kawasan hutan Sampali.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-2.1533,'lng'=>102.8883,'nama'=>'Desa Sepintun, Kec. Pauh, Kab. Sarolangun, Jambi','tanggal'=>'2024-07-18','sumber'=>'BKSDA Jambi / Mongabay','deskripsi'=>'Harimau mendekati pemukiman dan memangsa ternak warga.'],
            ['species_slug'=>'harimau-sumatra','lat'=>1.2500,'lng'=>102.0000,'nama'=>'Kab. Siak, Riau','tanggal'=>'2024-09-30','sumber'=>'BKSDA Riau','deskripsi'=>'Harimau memangsa ternak di perkebunan sawit yang berbatasan langsung dengan hutan.'],
            ['species_slug'=>'harimau-sumatra','lat'=>0.2833,'lng'=>100.3500,'nama'=>'Jorong Tikalak, Nagari Tj. Beringin Selatan, Kec. Lubuk Sikaping, Pasaman','tanggal'=>'2023-05-12','sumber'=>'BKSDA Sumbar / Mongabay','deskripsi'=>'Harimau Sumatra ditemukan mati akibat jerat babi di ladang warga.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-0.1333,'lng'=>100.2500,'nama'=>'Kec. Palembayan, Kab. Agam, Sumbar','tanggal'=>'2024-07-20','sumber'=>'BKSDA Sumbar','deskripsi'=>'Harimau Sumatra dievakuasi setelah mati akibat jerat di kebun warga Kecamatan Palembayan.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-1.6500,'lng'=>101.3000,'nama'=>'Kawasan TN Kerinci Seblat, Jambi','tanggal'=>'2022-06-15','sumber'=>'Balai TNKS','deskripsi'=>'Harimau terekam camera trap TNKS mendekati batas taman nasional dekat pemukiman.'],

            // =============================================================
            // GAJAH SUMATRA (Elephas maximus sumatranus)
            // =============================================================
            ['species_slug'=>'gajah-sumatra','lat'=>-3.3497,'lng'=>103.1475,'nama'=>'Desa Tri Anggun Jaya, Kec. Muara Lakitan, Kab. Musi Rawas, Sumsel','tanggal'=>'2024-09-08','sumber'=>'Mongabay Indonesia / BKSDA Sumsel','deskripsi'=>'Warga menjadi korban saat gajah memasuki kebun karet di lanskap Semangus.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.899,'lng'=>96.585,'nama'=>'Desa Karang Ampar, Kec. Ketol, Kab. Aceh Tengah','tanggal'=>'2024-03-15','sumber'=>'BKSDA Aceh / Mongabay','deskripsi'=>'Kawanan gajah merusak lahan pertanian di DAS Peusangan. Konflik kronis sejak 2013.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.8744,'lng'=>95.6453,'nama'=>'Kab. Aceh Jaya, Aceh','tanggal'=>'2024-06-20','sumber'=>'BKSDA Aceh','deskripsi'=>'Gajah liar memasuki perkebunan dan merusak tanaman warga. Bagian dari 114 kasus konflik gajah di Aceh 2024.'],
            ['species_slug'=>'gajah-sumatra','lat'=>-5.0785,'lng'=>105.7582,'nama'=>'TN Way Kambas (zona penyangga), Kab. Lampung Timur','tanggal'=>'2024-07-22','sumber'=>'Balai TN Way Kambas / KLHK','deskripsi'=>'Kawanan gajah keluar dari TN dan merusak kebun jagung serta singkong warga. Tercatat 128 interaksi negatif.'],
            ['species_slug'=>'gajah-sumatra','lat'=>-5.1711,'lng'=>105.7221,'nama'=>'Desa Braja Asri, Kec. Way Jepara, Kab. Lampung Timur','tanggal'=>'2024-11-05','sumber'=>'Mongabay Indonesia','deskripsi'=>'Kawanan gajah sering merusak kebun hingga pemukiman warga di penyangga TN Way Kambas.'],
            ['species_slug'=>'gajah-sumatra','lat'=>0.1147,'lng'=>101.9983,'nama'=>'Kawasan TN Tesso Nilo, Kab. Pelalawan, Riau','tanggal'=>'2024-04-10','sumber'=>'BKSDA Riau','deskripsi'=>'Gajah masuk area perkebunan sawit. Penelitian MaxEnt mencatat 130 titik potensi konflik.'],
            ['species_slug'=>'gajah-sumatra','lat'=>-5.1942,'lng'=>104.3083,'nama'=>'Kab. Lampung Barat, Lampung','tanggal'=>'2024-12-18','sumber'=>'Mongabay Indonesia','deskripsi'=>'Kawanan gajah mendekati pemukiman. Masyarakat mengusir dengan kentongan.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.3500,'lng'=>96.3200,'nama'=>'Kec. Peunaron, Kab. Aceh Timur','tanggal'=>'2023-08-10','sumber'=>'BKSDA Aceh','deskripsi'=>'Gajah merusak kebun sawit rakyat di area yang berbatasan dengan Ekosistem Leuser.'],
            ['species_slug'=>'gajah-sumatra','lat'=>2.9500,'lng'=>99.0500,'nama'=>'Kec. Dolok Panribuan, Kab. Simalungun, Sumut','tanggal'=>'2022-04-20','sumber'=>'BBKSDA Sumut','deskripsi'=>'Kawanan gajah memasuki ladang jagung warga di Simalungun.'],

            // =============================================================
            // TAPIR ASIA (Tapirus indicus)
            // =============================================================
            ['species_slug'=>'tapir-asia','lat'=>-0.3200,'lng'=>100.3700,'nama'=>'Kab. Solok, Sumbar','tanggal'=>'2024-01-18','sumber'=>'BKSDA Sumbar','deskripsi'=>'Tapir ditemukan terluka di pinggir jalan lintas Sumatra akibat tertabrak kendaraan.'],
            ['species_slug'=>'tapir-asia','lat'=>0.0833,'lng'=>100.5000,'nama'=>'Nagari Tanjung Pauh, Kec. Pangkalan Koto Baru, Kab. Lima Puluh Kota, Sumbar','tanggal'=>'2021-07-15','sumber'=>'BKSDA Sumbar','deskripsi'=>'Tapir terjerat perangkap babi di kebun gambir warga. Dievakuasi dan dilepasliarkan.'],
            ['species_slug'=>'tapir-asia','lat'=>0.3167,'lng'=>99.9500,'nama'=>'Nagari Balah Air, Kab. Padang Pariaman, Sumbar','tanggal'=>'2022-09-20','sumber'=>'BKSDA Sumbar','deskripsi'=>'Tapir terperosok ke dalam parit di pemukiman. Dievakuasi untuk pemeriksaan kesehatan.'],
            ['species_slug'=>'tapir-asia','lat'=>0.0250,'lng'=>100.0083,'nama'=>'Kab. Pasaman Barat, Sumbar','tanggal'=>'2024-12-10','sumber'=>'BKSDA Sumbar','deskripsi'=>'Tapir terjebak di kolam Dinas Perikanan setelah dikejar anjing warga. Tim BKSDA evakuasi.'],
            ['species_slug'=>'tapir-asia','lat'=>-4.5500,'lng'=>104.4000,'nama'=>'Kawasan Register 45, Kab. Mesuji, Lampung','tanggal'=>'2023-03-14','sumber'=>'BKSDA Lampung','deskripsi'=>'Tapir terlihat menyeberang Jalan Lintas Sumatera di Register 45. Warga melaporkan ke BKSDA.'],

            // =============================================================
            // BERUANG MADU (Helarctos malayanus)
            // =============================================================
            ['species_slug'=>'beruang-madu','lat'=>-0.1333,'lng'=>100.2167,'nama'=>'Kec. Palembayan, Kab. Agam, Sumbar','tanggal'=>'2024-03-22','sumber'=>'BKSDA Sumbar','deskripsi'=>'Beruang madu masuk ke kebun warga dan memakan kelapa serta nangka.'],
            ['species_slug'=>'beruang-madu','lat'=>-0.0842,'lng'=>100.3653,'nama'=>'Kec. Ampek Koto, Kab. Agam, Sumbar','tanggal'=>'2024-05-10','sumber'=>'BKSDA Sumbar','deskripsi'=>'Beruang madu masuk pemukiman mencari makanan. Warga melaporkan kerusakan kebun buah.'],
            ['species_slug'=>'beruang-madu','lat'=>0.3500,'lng'=>101.4500,'nama'=>'Kab. Kampar, Riau','tanggal'=>'2023-11-05','sumber'=>'BKSDA Riau','deskripsi'=>'Beruang madu merusak sarang lebah dan kebun durian warga di pinggir hutan.'],
            ['species_slug'=>'beruang-madu','lat'=>-1.5900,'lng'=>101.2500,'nama'=>'Kawasan TN Kerinci Seblat, Jambi','tanggal'=>'2022-08-18','sumber'=>'Balai TNKS','deskripsi'=>'Beruang madu terekam camera trap memasuki area ladang kopi di batas TNKS.'],

            // =============================================================
            // BABI HUTAN (Sus scrofa)
            // =============================================================
            ['species_slug'=>'babi-hutan','lat'=>0.8167,'lng'=>101.6333,'nama'=>'Kec. Mandau, Kab. Bengkalis, Riau','tanggal'=>'2024-02-15','sumber'=>'BKSDA Riau / Dinas Pertanian','deskripsi'=>'Kawanan babi hutan merusak ladang jagung dan singkong di area dekat konsesi sawit.'],
            ['species_slug'=>'babi-hutan','lat'=>-2.5000,'lng'=>101.5000,'nama'=>'Kab. Bungo, Jambi','tanggal'=>'2023-06-10','sumber'=>'Dinas Pertanian Jambi','deskripsi'=>'Babi hutan merusak tanaman padi di sawah warga. Petani memasang jerat.'],
            ['species_slug'=>'babi-hutan','lat'=>-0.5000,'lng'=>100.5000,'nama'=>'Kab. Tanah Datar, Sumbar','tanggal'=>'2024-04-08','sumber'=>'BKSDA Sumbar','deskripsi'=>'Kawanan babi hutan merusak kebun sayur dan ladang cabai warga.'],
            ['species_slug'=>'babi-hutan','lat'=>3.1000,'lng'=>99.0500,'nama'=>'Kab. Simalungun, Sumut','tanggal'=>'2022-10-15','sumber'=>'Dinas Pertanian Sumut','deskripsi'=>'Babi hutan merusak area perkebunan jagung dan singkong.'],

            // =============================================================
            // RUSA SAMBAR (Rusa unicolor)
            // =============================================================
            ['species_slug'=>'rusa-sambar','lat'=>-5.3167,'lng'=>104.6333,'nama'=>'Pekon Way Haru, Kec. Bangkunat, Kab. Pesisir Barat, Lampung','tanggal'=>'2024-12-08','sumber'=>'Polres Pesisir Barat','deskripsi'=>'Tiga pelaku perburuan rusa sambar menggunakan jerat ditangkap di kawasan TWNC.'],
            ['species_slug'=>'rusa-sambar','lat'=>-0.4167,'lng'=>100.1500,'nama'=>'Nagari Kasang, Kec. Batang Anai, Kab. Padang Pariaman, Sumbar','tanggal'=>'2022-10-18','sumber'=>'BKSDA Sumbar / Polsek Batang Anai','deskripsi'=>'Tujuh pemburu rusa sambar ditangkap di Suaka Margasatwa Barisan menggunakan senjata rakitan.'],
            ['species_slug'=>'rusa-sambar','lat'=>-5.5000,'lng'=>105.0000,'nama'=>'Kec. Pematang Sawa, Kab. Tanggamus, Lampung','tanggal'=>'2024-05-20','sumber'=>'Polres Tanggamus','deskripsi'=>'Lima pemburu rusa sambar ditangkap di Dusun Way Jambu membawa potongan tubuh rusa.'],

            // =============================================================
            // KIJANG MUNTJAK (Muntiacus muntjak)
            // =============================================================
            ['species_slug'=>'kijang-muntjak','lat'=>-0.9167,'lng'=>100.4000,'nama'=>'Kec. Kuranji, Kota Padang, Sumbar','tanggal'=>'2021-11-15','sumber'=>'BKSDA Sumbar','deskripsi'=>'Penangkapan pemuda yang menjual kepala kijang dan rusa hasil buruan.'],
            ['species_slug'=>'kijang-muntjak','lat'=>-0.8500,'lng'=>100.3500,'nama'=>'Kota Padang, Sumbar','tanggal'=>'2020-02-10','sumber'=>'BKSDA Sumbar','deskripsi'=>'BKSDA menggagalkan pengiriman tanduk dan kepala rusa/kijang via jasa ekspedisi ke Tangerang.'],
            ['species_slug'=>'kijang-muntjak','lat'=>-1.6000,'lng'=>101.3500,'nama'=>'Kawasan TN Kerinci Seblat, Jambi','tanggal'=>'2023-09-22','sumber'=>'Balai TNKS','deskripsi'=>'Kijang ditemukan terjerat jerat babi di batas taman nasional.'],

            // =============================================================
            // MONYET EKOR PANJANG (Macaca fascicularis)
            // =============================================================
            ['species_slug'=>'monyet-ekor-panjang','lat'=>1.3000,'lng'=>102.0000,'nama'=>'Kab. Siak, Riau','tanggal'=>'2024-06-12','sumber'=>'BRIN / BKSDA Riau','deskripsi'=>'Konflik monyet ekor panjang merusak kebun jagung, singkong, dan pisang warga.'],
            ['species_slug'=>'monyet-ekor-panjang','lat'=>3.5833,'lng'=>98.6833,'nama'=>'Kab. Langkat, Sumut','tanggal'=>'2024-03-05','sumber'=>'BBKSDA Sumut','deskripsi'=>'Monyet agresif menyerang warga di pemukiman dekat kawasan hutan.'],
            ['species_slug'=>'monyet-ekor-panjang','lat'=>0.4000,'lng'=>101.4500,'nama'=>'Kab. Kampar, Riau','tanggal'=>'2023-08-20','sumber'=>'BKSDA Riau','deskripsi'=>'Kawanan monyet ekor panjang merusak kebun singkong dan kacang warga.'],

            // =============================================================
            // BERUK (Macaca nemestrina)
            // =============================================================
            ['species_slug'=>'beruk','lat'=>3.3500,'lng'=>98.5000,'nama'=>'Kota Binjai, Sumut','tanggal'=>'2023-04-10','sumber'=>'BBKSDA Sumut','deskripsi'=>'Beruk peliharaan diserahkan warga ke BKSDA setelah berpotensi konflik.'],
            ['species_slug'=>'beruk','lat'=>2.9500,'lng'=>99.0500,'nama'=>'Kab. Simalungun, Sumut','tanggal'=>'2024-01-22','sumber'=>'BBKSDA Sumut','deskripsi'=>'Beruk memasuki kebun sawit dan merusak buah sawit milik petani.'],

            // =============================================================
            // KAMBING HUTAN SUMATRA (Capricornis sumatraensis)
            // =============================================================
            ['species_slug'=>'kambing-hutan-sumatra','lat'=>2.2000,'lng'=>99.8500,'nama'=>'Kab. Labuhanbatu Utara, Sumut','tanggal'=>'2021-09-15','sumber'=>'BKSDA Sumut / Detik','deskripsi'=>'Kambing hutan dijerat warga di hutan lindung, disembelih dan dikonsumsi. BKSDA edukasi warga.'],
            ['species_slug'=>'kambing-hutan-sumatra','lat'=>2.0500,'lng'=>99.5500,'nama'=>'Kab. Asahan, Sumut','tanggal'=>'2024-02-18','sumber'=>'BBKSDA Sumut','deskripsi'=>'Anakan kambing hutan terluka akibat jerat diserahkan warga ke BBKSDA.'],
            ['species_slug'=>'kambing-hutan-sumatra','lat'=>1.6000,'lng'=>99.4000,'nama'=>'SM Barumun, Kab. Padang Lawas/Tapanuli Selatan, Sumut','tanggal'=>'2024-07-10','sumber'=>'BBKSDA Sumut','deskripsi'=>'Tim menemukan jerat pilubang 1000 meter yang mengancam kambing hutan dan kuau raja.'],

            // =============================================================
            // KUAU RAJA (Argusianus argus)
            // =============================================================
            ['species_slug'=>'kuau-raja','lat'=>1.6000,'lng'=>99.4000,'nama'=>'SM Barumun, Kab. Padang Lawas, Sumut','tanggal'=>'2024-07-10','sumber'=>'BBKSDA Sumut','deskripsi'=>'Jerat sepanjang 1000m ditemukan mengancam kuau raja dan satwa liar lainnya.'],
            ['species_slug'=>'kuau-raja','lat'=>-1.5500,'lng'=>101.3000,'nama'=>'TN Kerinci Seblat, Jambi','tanggal'=>'2023-04-15','sumber'=>'Balai TNKS','deskripsi'=>'Kuau raja terekam camera trap di area yang terganggu aktivitas manusia (perambahan).'],
            ['species_slug'=>'kuau-raja','lat'=>3.7500,'lng'=>97.5800,'nama'=>'Ekosistem Leuser, Kab. Langkat, Sumut','tanggal'=>'2022-11-08','sumber'=>'HAkA / BKSDA Aceh','deskripsi'=>'Kuau raja ditemukan terjerat di area perambahan hutan Leuser.'],

            // =============================================================
            // TRENGGILING SUNDA (Manis javanica)
            // =============================================================
            ['species_slug'=>'trenggiling-sunda','lat'=>0.0250,'lng'=>100.0083,'nama'=>'Kab. Pasaman Barat, Sumbar','tanggal'=>'2022-04-18','sumber'=>'BKSDA Sumbar / Polda','deskripsi'=>'Penyelundupan 22 kg sisik trenggiling digagalkan di Pasaman Barat.'],
            ['species_slug'=>'trenggiling-sunda','lat'=>-0.9500,'lng'=>100.3500,'nama'=>'Kota Padang, Sumbar','tanggal'=>'2024-09-10','sumber'=>'BKSDA Sumbar / Polda Sumbar','deskripsi'=>'Perdagangan puluhan kilogram sisik trenggiling diungkap di Padang.'],
            ['species_slug'=>'trenggiling-sunda','lat'=>1.6500,'lng'=>99.1500,'nama'=>'Kel. Pasar Sipirok, Kec. Sipirok, Kab. Tapanuli Selatan, Sumut','tanggal'=>'2024-05-20','sumber'=>'Polda Sumut','deskripsi'=>'Polda mengungkap perdagangan bagian tubuh satwa dilindungi, menyita 4,7 kg sisik trenggiling.'],

            // =============================================================
            // LANDAK RAYA (Hystrix brachyura)
            // =============================================================
            ['species_slug'=>'landak-raya','lat'=>-0.3000,'lng'=>100.3700,'nama'=>'Kota Bukittinggi, Sumbar','tanggal'=>'2022-06-12','sumber'=>'BKSDA Sumbar','deskripsi'=>'Landak masuk ke dalam rumah warga dan membuat panik. Dievakuasi oleh BKSDA.'],
            ['species_slug'=>'landak-raya','lat'=>-3.7500,'lng'=>103.7500,'nama'=>'Kab. Lahat, Sumsel','tanggal'=>'2023-08-20','sumber'=>'SKW II BKSDA Sumsel','deskripsi'=>'Landak ditemukan warga di area perkebunan dan diserahkan ke BKSDA.'],
            ['species_slug'=>'landak-raya','lat'=>-1.6000,'lng'=>103.6000,'nama'=>'Kab. Batang Hari, Jambi','tanggal'=>'2024-02-10','sumber'=>'SKW I BKSDA Jambi','deskripsi'=>'Landak diserahkan masyarakat yang ditemukan di area perkebunan kelapa sawit.'],

            // =============================================================
            // MUSANG LEHER KUNING (Martes flavigula)
            // =============================================================
            ['species_slug'=>'musang-leher-kuning','lat'=>-1.5500,'lng'=>101.3000,'nama'=>'TN Kerinci Seblat, Jambi','tanggal'=>'2023-06-15','sumber'=>'Balai TNKS','deskripsi'=>'Musang leher kuning terekam camera trap di area ladang kopi batas TNKS.'],
            ['species_slug'=>'musang-leher-kuning','lat'=>3.7500,'lng'=>97.5800,'nama'=>'Ekosistem Leuser, Kab. Langkat, Sumut','tanggal'=>'2024-03-10','sumber'=>'HAkA','deskripsi'=>'Musang leher kuning terjerat jerat non-selektif yang dipasang untuk babi hutan.'],

            // =============================================================
            // MUSANG AKAR (Paguma larvata)
            // =============================================================
            ['species_slug'=>'musang-akar','lat'=>-0.1658,'lng'=>100.3042,'nama'=>'Kec. Palupuh, Kab. Agam, Sumbar','tanggal'=>'2024-01-20','sumber'=>'BKSDA Sumbar','deskripsi'=>'Musang akar ditemukan terjerat di kebun warga. Jerat semula dipasang untuk babi hutan.'],
            ['species_slug'=>'musang-akar','lat'=>-0.4667,'lng'=>100.1167,'nama'=>'Nagari Maninjau, Kec. Tanjung Raya, Kab. Agam, Sumbar','tanggal'=>'2023-12-05','sumber'=>'BKSDA Sumbar','deskripsi'=>'Musang ditemukan di pohon kemiri di lokasi bencana banjir bandang. Dievakuasi BKSDA.'],

            // =============================================================
            // DATA 2015–2019 — Insiden historis
            // =============================================================

            // --- HARIMAU SUMATRA 2015-2019 ---
            ['species_slug'=>'harimau-sumatra','lat'=>0.3500,'lng'=>101.8000,'nama'=>'Desa Simpang Gaung, Kec. Gaung, Kab. Indragiri Hilir, Riau','tanggal'=>'2019-03-02','sumber'=>'CNN Indonesia / BBKSDA Riau','deskripsi'=>'Seorang pria diterkam harimau saat mengolah kayu di hutan Sungai Raya.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-0.0842,'lng'=>100.3653,'nama'=>'Kec. Ampek Koto, Kab. Agam, Sumbar','tanggal'=>'2019-08-15','sumber'=>'BKSDA Sumbar','deskripsi'=>'Harimau memangsa ternak sapi warga di kebun yang berbatasan dengan hutan lindung.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-5.4000,'lng'=>104.6500,'nama'=>'Resort Pemerihan, TNBBS, Kab. Pesisir Barat, Lampung','tanggal'=>'2018-06-10','sumber'=>'Balai TNBBS','deskripsi'=>'Harimau terekam camera trap di lahan kopi warga dalam kawasan penyangga TNBBS.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-1.7000,'lng'=>101.3500,'nama'=>'Kawasan TN Kerinci Seblat, Merangin, Jambi','tanggal'=>'2017-11-22','sumber'=>'Balai TNKS / Mongabay','deskripsi'=>'Harimau memangsa kambing di pemukiman pinggir TNKS.'],
            ['species_slug'=>'harimau-sumatra','lat'=>0.1994,'lng'=>100.0561,'nama'=>'Kab. Pasaman, Sumbar','tanggal'=>'2016-04-18','sumber'=>'BKSDA Sumbar','deskripsi'=>'Harimau masuk ke ladang sawit dan memangsa sapi warga di pinggir hutan.'],
            ['species_slug'=>'harimau-sumatra','lat'=>-2.5000,'lng'=>101.5500,'nama'=>'Kab. Bungo, Jambi','tanggal'=>'2015-09-05','sumber'=>'BKSDA Jambi','deskripsi'=>'Harimau menyerang ternak di desa pinggir hutan. Warga memasang kandang jebak bersama BKSDA.'],

            // --- GAJAH SUMATRA 2015-2019 ---
            ['species_slug'=>'gajah-sumatra','lat'=>4.3500,'lng'=>96.3200,'nama'=>'Desa Sri Mulya, Kec. Peunaron, Kab. Aceh Timur','tanggal'=>'2019-07-15','sumber'=>'CNN Indonesia / BKSDA Aceh','deskripsi'=>'Kawanan gajah masuk perkebunan warga. Tercatat 107 kasus konflik gajah di Aceh tahun 2019.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.0500,'lng'=>96.5000,'nama'=>'Desa Tuwi Meuleusong, Kec. Seunagan Timur, Kab. Nagan Raya, Aceh','tanggal'=>'2019-06-20','sumber'=>'Betahita / Kompas','deskripsi'=>'Kawanan gajah liar merusak rumah dan kebun kelapa sawit warga di tiga desa.'],
            ['species_slug'=>'gajah-sumatra','lat'=>0.5000,'lng'=>101.4500,'nama'=>'Kel. Okura, Kec. Rumbai Pesisir, Kota Pekanbaru, Riau','tanggal'=>'2016-02-26','sumber'=>'WWF Indonesia','deskripsi'=>'Gajah masuk ke pemukiman di Danau Buatan, memicu kepanikan warga.'],
            ['species_slug'=>'gajah-sumatra','lat'=>0.2500,'lng'=>102.1000,'nama'=>'Desa Lubuk Kembang Bunga, Kab. Pelalawan, Riau','tanggal'=>'2018-05-12','sumber'=>'BBKSDA Riau','deskripsi'=>'Gajah merusak kebun sawit dan palawija di desa penyangga TN Tesso Nilo.'],
            ['species_slug'=>'gajah-sumatra','lat'=>-5.0785,'lng'=>105.7582,'nama'=>'Kec. Way Jepara, Kab. Lampung Timur','tanggal'=>'2017-08-20','sumber'=>'Balai TN Way Kambas','deskripsi'=>'Kawanan gajah keluar TN Way Kambas merusak tanaman warga. Tercatat 122 kasus konflik.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.2000,'lng'=>96.7500,'nama'=>'Desa Alur Kuyun, Kec. Rusip Antara, Kab. Aceh Tengah','tanggal'=>'2019-10-05','sumber'=>'Mongabay Indonesia / BKSDA Aceh','deskripsi'=>'Gajah terluka akibat jerat di area perkebunan. Dievakuasi BKSDA.'],
            ['species_slug'=>'gajah-sumatra','lat'=>4.5000,'lng'=>97.0000,'nama'=>'Kab. Aceh Utara','tanggal'=>'2017-03-10','sumber'=>'BKSDA Aceh','deskripsi'=>'Konflik gajah-manusia: kawanan merusak kebun jagung dan pisang warga.'],
            ['species_slug'=>'gajah-sumatra','lat'=>-5.3000,'lng'=>104.4000,'nama'=>'Resort Pemerihan, TNBBS, Lampung','tanggal'=>'2015-12-08','sumber'=>'Balai TNBBS','deskripsi'=>'Gajah memasuki area ladang di desa penyangga TNBBS.'],

            // --- TAPIR ASIA 2015-2019 ---
            ['species_slug'=>'tapir-asia','lat'=>-0.4500,'lng'=>100.3500,'nama'=>'Kab. Pesisir Selatan, Sumbar','tanggal'=>'2018-03-20','sumber'=>'BKSDA Sumbar','deskripsi'=>'Tapir ditemukan mati di pinggir jalan lintas Sumatra, diduga tertabrak kendaraan.'],
            ['species_slug'=>'tapir-asia','lat'=>-1.6000,'lng'=>101.3500,'nama'=>'Kawasan TN Kerinci Seblat, Jambi','tanggal'=>'2016-07-12','sumber'=>'Balai TNKS','deskripsi'=>'Tapir terekam camera trap di jalur yang terfragmentasi oleh perkebunan kopi.'],

            // --- BERUANG MADU 2015-2019 ---
            ['species_slug'=>'beruang-madu','lat'=>0.1000,'lng'=>102.1500,'nama'=>'Kab. Pelalawan, Riau','tanggal'=>'2019-04-15','sumber'=>'BBKSDA Riau','deskripsi'=>'Beruang madu dipelihara ilegal oleh warga. Dievakuasi dan dibawa ke pusat rehabilitasi.'],
            ['species_slug'=>'beruang-madu','lat'=>-0.4500,'lng'=>100.3500,'nama'=>'Kab. Pesisir Selatan, Sumbar','tanggal'=>'2017-09-08','sumber'=>'BKSDA Sumbar','deskripsi'=>'Beruang madu terjerat jerat babi di kebun warga. Dievakuasi BKSDA.'],
            ['species_slug'=>'beruang-madu','lat'=>-5.4000,'lng'=>104.6500,'nama'=>'Kawasan TNBBS, Lampung','tanggal'=>'2016-01-22','sumber'=>'Balai TNBBS','deskripsi'=>'Beruang madu terekam camera trap memasuki kebun kopi di zona penyangga TNBBS.'],

            // --- BABI HUTAN 2015-2019 ---
            ['species_slug'=>'babi-hutan','lat'=>0.3500,'lng'=>101.4500,'nama'=>'Kab. Kampar, Riau','tanggal'=>'2019-05-10','sumber'=>'Dinas Pertanian Riau','deskripsi'=>'Kawanan babi hutan merusak ladang jagung. Warga memasang jerat yang juga mengenai satwa dilindungi.'],
            ['species_slug'=>'babi-hutan','lat'=>-0.3000,'lng'=>100.3500,'nama'=>'Kab. Solok, Sumbar','tanggal'=>'2017-07-18','sumber'=>'BKSDA Sumbar','deskripsi'=>'Babi hutan merusak kebun sayur warga. Jerat yang dipasang turut menjerat harimau.'],
            ['species_slug'=>'babi-hutan','lat'=>-5.0500,'lng'=>105.3000,'nama'=>'Kab. Lampung Tengah','tanggal'=>'2018-11-05','sumber'=>'Dinas Pertanian Lampung','deskripsi'=>'Babi hutan merusak area persawahan di sekitar kawasan hutan Register.'],

            // --- RUSA SAMBAR 2015-2019 ---
            ['species_slug'=>'rusa-sambar','lat'=>-5.4000,'lng'=>104.6500,'nama'=>'Kawasan TNBBS, Lampung','tanggal'=>'2018-04-15','sumber'=>'Balai TNBBS','deskripsi'=>'Rusa sambar ditemukan mati terjerat di area perbatasan taman nasional.'],
            ['species_slug'=>'rusa-sambar','lat'=>-0.9167,'lng'=>100.4000,'nama'=>'Kota Padang, Sumbar','tanggal'=>'2016-08-22','sumber'=>'BKSDA Sumbar','deskripsi'=>'Perburuan rusa sambar diungkap di kawasan hutan kota. Dua pelaku ditangkap.'],

            // --- MONYET EKOR PANJANG 2015-2019 ---
            ['species_slug'=>'monyet-ekor-panjang','lat'=>0.5000,'lng'=>101.4500,'nama'=>'Kota Pekanbaru, Riau','tanggal'=>'2019-09-12','sumber'=>'BBKSDA Riau','deskripsi'=>'Monyet ekor panjang menyerang warga di area pemukiman dekat hutan.'],
            ['species_slug'=>'monyet-ekor-panjang','lat'=>3.5833,'lng'=>98.6833,'nama'=>'Kab. Langkat, Sumut','tanggal'=>'2018-06-25','sumber'=>'BBKSDA Sumut','deskripsi'=>'Kawanan monyet merusak kebun jagung dan singkong warga di pinggir kawasan hutan.'],

            // --- TRENGGILING SUNDA 2015-2019 ---
            ['species_slug'=>'trenggiling-sunda','lat'=>0.3500,'lng'=>101.4500,'nama'=>'Kab. Kampar, Riau','tanggal'=>'2019-11-15','sumber'=>'BBKSDA Riau / Polda Riau','deskripsi'=>'Polisi mengungkap jaringan perdagangan trenggiling hidup dan sisik di Riau.'],
            ['species_slug'=>'trenggiling-sunda','lat'=>2.9500,'lng'=>99.0500,'nama'=>'Kab. Simalungun, Sumut','tanggal'=>'2017-03-20','sumber'=>'BBKSDA Sumut','deskripsi'=>'Trenggiling diserahkan warga ke BBKSDA setelah ditemukan di kebun sawit.'],

            // --- LANDAK RAYA 2015-2019 ---
            ['species_slug'=>'landak-raya','lat'=>-0.1333,'lng'=>100.2167,'nama'=>'Kec. Palembayan, Kab. Agam, Sumbar','tanggal'=>'2019-02-10','sumber'=>'BKSDA Sumbar','deskripsi'=>'Landak masuk ke area perkebunan dan merusak tanaman singkong warga.'],

            // --- KIJANG MUNTJAK 2015-2019 ---
            ['species_slug'=>'kijang-muntjak','lat'=>-1.7000,'lng'=>101.3500,'nama'=>'Kawasan TNKS, Merangin, Jambi','tanggal'=>'2017-05-15','sumber'=>'Balai TNKS','deskripsi'=>'Kijang ditemukan terjerat jerat kawat di batas taman nasional.'],

            // --- KAMBING HUTAN 2015-2019 ---
            ['species_slug'=>'kambing-hutan-sumatra','lat'=>3.7500,'lng'=>97.5800,'nama'=>'Ekosistem Leuser, Kab. Langkat, Sumut','tanggal'=>'2018-08-12','sumber'=>'HAkA / BBKSDA Sumut','deskripsi'=>'Kambing hutan terekam camera trap di area yang terancam perambahan.'],

            // --- KUAU RAJA 2015-2019 ---
            ['species_slug'=>'kuau-raja','lat'=>-1.6000,'lng'=>101.3500,'nama'=>'TN Kerinci Seblat, Jambi','tanggal'=>'2019-01-20','sumber'=>'Balai TNKS','deskripsi'=>'Kuau raja terekam camera trap di area hutan yang mulai terdegradasi.'],
        ];

        foreach ($incidents as $data) {
            $species = Species::where('slug', $data['species_slug'])->first();

            if ($species) {
                ConflictIncident::create([
                    'species_id'  => $species->id,
                    'lokasi_lat'  => $data['lat'],
                    'lokasi_lng'  => $data['lng'],
                    'lokasi_nama' => $data['nama'],
                    'tanggal'     => $data['tanggal'],
                    'sumber'      => $data['sumber'],
                    'deskripsi'   => $data['deskripsi'],
                ]);
            }
        }
    }
}
