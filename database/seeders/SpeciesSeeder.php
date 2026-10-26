<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $speciesData = [
            // ============================================================
            // 14 spesies sesuai kelas model AI (folder training ResNet50)
            // ============================================================
            [
                'nama_ilmiah' => 'Panthera tigris sumatrae',
                'nama_umum' => 'Harimau Sumatra',
                'slug' => 'harimau-sumatra',
                'status_konservasi' => 'Kritis',
                'deskripsi' => 'Harimau Sumatra adalah subspesies harimau terkecil yang masih bertahan hidup. Hanya ditemukan di Pulau Sumatra, Indonesia, dan merupakan satu-satunya subspesies harimau yang tersisa di Indonesia setelah punahnya Harimau Jawa dan Harimau Bali. Populasinya diperkirakan hanya tersisa sekitar 400-600 ekor di alam liar.',
                'habitat' => 'Hutan hujan tropis dataran rendah hingga pegunungan',
                'ancaman_utama' => 'Perburuan ilegal, deforestasi untuk perkebunan kelapa sawit, konflik dengan manusia, fragmentasi habitat.',
                'jumlah_terdeteksi' => 47,
            ],
            [
                'nama_ilmiah' => 'Elephas maximus sumatranus',
                'nama_umum' => 'Gajah Sumatra',
                'slug' => 'gajah-sumatra',
                'status_konservasi' => 'Kritis',
                'deskripsi' => 'Gajah Sumatra adalah subspesies gajah Asia yang endemik di Pulau Sumatra. Merupakan mamalia darat terbesar di Indonesia dengan berat mencapai 5 ton. Populasinya menurun drastis dalam 25 tahun terakhir akibat hilangnya habitat.',
                'habitat' => 'Hutan hujan tropis dataran rendah, hutan sekunder',
                'ancaman_utama' => 'Konversi lahan untuk perkebunan, konflik dengan petani, perburuan gading.',
                'jumlah_terdeteksi' => 62,
            ],
            [
                'nama_ilmiah' => 'Tapirus indicus',
                'nama_umum' => 'Tapir Asia',
                'slug' => 'tapir-asia',
                'status_konservasi' => 'Terancam Punah',
                'deskripsi' => 'Tapir Asia atau Tapir Melayu adalah spesies tapir terbesar dan satu-satunya yang ditemukan di luar Amerika. Tubuhnya berwarna hitam dan putih yang khas, membantu kamuflase di hutan. Merupakan herbivora penting dalam ekosistem hutan.',
                'habitat' => 'Hutan hujan tropis primer dan sekunder, dekat sumber air',
                'ancaman_utama' => 'Fragmentasi habitat, perburuan, pembangunan jalan melalui habitat.',
                'jumlah_terdeteksi' => 28,
            ],
            [
                'nama_ilmiah' => 'Helarctos malayanus',
                'nama_umum' => 'Beruang Madu',
                'slug' => 'beruang-madu',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Beruang Madu adalah spesies beruang terkecil di dunia. Dinamakan demikian karena kesukaannya terhadap madu. Memiliki lidah yang sangat panjang (sekitar 25 cm) untuk mengambil madu dan serangga dari sarang.',
                'habitat' => 'Hutan hujan tropis dataran rendah hingga pegunungan',
                'ancaman_utama' => 'Perdagangan empedu dan bagian tubuh, kehilangan habitat, perburuan.',
                'jumlah_terdeteksi' => 41,
            ],
            [
                'nama_ilmiah' => 'Rusa unicolor',
                'nama_umum' => 'Rusa Sambar',
                'slug' => 'rusa-sambar',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Rusa Sambar adalah spesies rusa terbesar di Asia Tenggara. Pejantan memiliki tanduk bercabang tiga yang bisa mencapai panjang 1 meter. Merupakan mangsa utama bagi Harimau Sumatra, menjadikannya komponen penting dalam rantai makanan.',
                'habitat' => 'Hutan hujan, padang rumput, dekat sumber air',
                'ancaman_utama' => 'Perburuan untuk daging dan tanduk, hilangnya habitat.',
                'jumlah_terdeteksi' => 89,
            ],
            [
                'nama_ilmiah' => 'Sus scrofa',
                'nama_umum' => 'Babi Hutan',
                'slug' => 'babi-hutan',
                'status_konservasi' => 'Risiko Rendah',
                'deskripsi' => 'Babi Hutan adalah mamalia omnivora yang tersebar luas. Di ekosistem hutan Sumatra, babi hutan berperan penting sebagai mangsa utama predator besar dan membantu penyebaran biji melalui aktivitas mencari makan di tanah.',
                'habitat' => 'Beragam tipe habitat, dari hutan hingga area pertanian',
                'ancaman_utama' => 'Perburuan, meskipun populasi relatif stabil dibanding spesies lain.',
                'jumlah_terdeteksi' => 156,
            ],
            [
                'nama_ilmiah' => 'Muntiacus muntjak',
                'nama_umum' => 'Kijang Muntjak',
                'slug' => 'kijang-muntjak',
                'status_konservasi' => 'Risiko Rendah',
                'deskripsi' => 'Kijang Muntjak atau Muncak adalah rusa terkecil di Asia Tenggara. Dikenal juga sebagai barking deer karena suaranya yang menyerupai gonggongan anjing ketika merasa terancam. Merupakan satwa soliter yang aktif di pagi dan senja.',
                'habitat' => 'Hutan hujan tropis, hutan sekunder, semak belukar',
                'ancaman_utama' => 'Perburuan subsisten, fragmentasi habitat.',
                'jumlah_terdeteksi' => 112,
            ],
            [
                'nama_ilmiah' => 'Hystrix brachyura',
                'nama_umum' => 'Landak Raya',
                'slug' => 'landak-raya',
                'status_konservasi' => 'Risiko Rendah',
                'deskripsi' => 'Landak Raya adalah rodensia berduri terbesar di Asia Tenggara. Duri-durinya yang panjang dan tajam merupakan pertahanan efektif terhadap predator. Merupakan hewan nokturnal yang membuat liang di tanah.',
                'habitat' => 'Hutan primer dan sekunder, area berbatu, dekat perkebunan',
                'ancaman_utama' => 'Perburuan untuk daging dan duri (dipercaya berkhasiat obat).',
                'jumlah_terdeteksi' => 67,
            ],
            [
                'nama_ilmiah' => 'Macaca nemestrina',
                'nama_umum' => 'Beruk',
                'slug' => 'beruk',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Beruk adalah salah satu jenis kera ekor pendek yang tersebar luas di hutan Sumatra. Dikenal cerdas dan mudah beradaptasi, beruk hidup berkelompok dan sering terlihat di camera trap karena aktivitas hariannya yang tinggi di lantai maupun kanopi hutan.',
                'habitat' => 'Hutan primer dan sekunder, dataran rendah hingga perbukitan',
                'ancaman_utama' => 'Hilangnya habitat, perburuan, konflik dengan manusia di area perkebunan.',
                'jumlah_terdeteksi' => 34,
            ],
            [
                'nama_ilmiah' => 'Macaca fascicularis',
                'nama_umum' => 'Monyet Ekor Panjang',
                'slug' => 'monyet-ekor-panjang',
                'status_konservasi' => 'Terancam Punah',
                'deskripsi' => 'Monyet Ekor Panjang adalah primata yang sangat adaptif, ditemukan mulai dari hutan alami hingga area dekat pemukiman manusia. Populasinya sempat dianggap melimpah, namun penilaian IUCN terbaru menaikkan status konservasinya akibat perburuan dan perdagangan.',
                'habitat' => 'Hutan riparian, hutan sekunder, area dekat sungai',
                'ancaman_utama' => 'Perdagangan untuk penelitian, perburuan, konflik dengan manusia.',
                'jumlah_terdeteksi' => 78,
            ],
            [
                'nama_ilmiah' => 'Argusianus argus',
                'nama_umum' => 'Kuau Raja',
                'slug' => 'kuau-raja',
                'status_konservasi' => 'Hampir Terancam',
                'deskripsi' => 'Kuau Raja adalah burung berukuran besar dari keluarga pegar, terkenal dengan bulu ekor jantan yang sangat panjang dan tarian kawin yang rumit. Sering terekam camera trap karena kebiasaannya mencari makan di lantai hutan.',
                'habitat' => 'Hutan hujan tropis dataran rendah yang belum terganggu',
                'ancaman_utama' => 'Deforestasi, perburuan untuk bulu dan perdagangan satwa.',
                'jumlah_terdeteksi' => 25,
            ],
            [
                'nama_ilmiah' => 'Capricornis sumatraensis',
                'nama_umum' => 'Kambing Hutan Sumatra',
                'slug' => 'kambing-hutan-sumatra',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Kambing Hutan Sumatra adalah mamalia mirip kambing yang hidup di area berbukit dan bergunung. Kemampuannya memanjat medan curam membuatnya jarang terlihat langsung, namun cukup sering terekam camera trap di jalur pegunungan.',
                'habitat' => 'Hutan pegunungan, area berbatu dan curam',
                'ancaman_utama' => 'Perburuan, hilangnya habitat akibat pembukaan lahan.',
                'jumlah_terdeteksi' => 18,
            ],
            [
                'nama_ilmiah' => 'Martes flavigula',
                'nama_umum' => 'Musang Leher Kuning',
                'slug' => 'musang-leher-kuning',
                'status_konservasi' => 'Risiko Rendah',
                'deskripsi' => 'Musang Leher Kuning adalah karnivora kecil yang gesit, dikenali dari corak leher kuning cerah yang kontras dengan tubuhnya. Merupakan predator oportunistik yang memangsa serangga, buah, hingga vertebrata kecil.',
                'habitat' => 'Hutan primer dan sekunder, dataran rendah hingga pegunungan',
                'ancaman_utama' => 'Hilangnya habitat, meski populasi relatif stabil dibanding spesies lain.',
                'jumlah_terdeteksi' => 31,
            ],
            [
                'nama_ilmiah' => 'Paguma larvata',
                'nama_umum' => 'Musang Akar',
                'slug' => 'musang-akar',
                'status_konservasi' => 'Risiko Rendah',
                'deskripsi' => 'Musang Akar adalah karnivora nokturnal dari keluarga Viverridae, dikenali dari corak wajah seperti topeng. Berperan penting dalam penyebaran biji buah-buahan hutan melalui aktivitas makannya.',
                'habitat' => 'Hutan primer dan sekunder, area dekat perkebunan',
                'ancaman_utama' => 'Perburuan, perdagangan sebagai bagian dari industri kopi luwak.',
                'jumlah_terdeteksi' => 45,
            ],
        ];

        foreach ($speciesData as $data) {
            Species::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}