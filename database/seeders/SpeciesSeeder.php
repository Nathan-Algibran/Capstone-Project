<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $speciesData = [
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
                'nama_ilmiah' => 'Dicerorhinus sumatrensis',
                'nama_umum' => 'Badak Sumatra',
                'slug' => 'badak-sumatra',
                'status_konservasi' => 'Kritis',
                'deskripsi' => 'Badak Sumatra adalah badak terkecil dan satu-satunya badak Asia yang memiliki dua cula. Merupakan salah satu mamalia paling terancam punah di dunia dengan populasi diperkirakan kurang dari 80 ekor di alam liar.',
                'habitat' => 'Hutan hujan tropis pegunungan dan dataran rendah',
                'ancaman_utama' => 'Perburuan cula, hilangnya habitat, populasi terlalu kecil untuk reproduksi efektif.',
                'jumlah_terdeteksi' => 8,
            ],
            [
                'nama_ilmiah' => 'Pongo abelii',
                'nama_umum' => 'Orangutan Sumatra',
                'slug' => 'orangutan-sumatra',
                'status_konservasi' => 'Kritis',
                'deskripsi' => 'Orangutan Sumatra adalah primata besar yang hanya ditemukan di bagian utara Pulau Sumatra. Mereka menghabiskan hampir seluruh hidupnya di atas pohon dan merupakan hewan paling arboreal di antara semua kera besar.',
                'habitat' => 'Hutan hujan tropis dataran rendah, hutan rawa gambut',
                'ancaman_utama' => 'Deforestasi masif untuk kelapa sawit, perdagangan ilegal, kebakaran hutan.',
                'jumlah_terdeteksi' => 35,
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
                'nama_ilmiah' => 'Neofelis nebulosa',
                'nama_umum' => 'Macan Dahan',
                'slug' => 'macan-dahan',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Macan Dahan memiliki taring terpanjang dibandingkan ukuran tubuhnya di antara semua kucing besar. Merupakan pemanjat pohon yang sangat handal dan sering berburu dari atas pohon. Corak bulunya yang seperti awan memberikan kamuflase sempurna.',
                'habitat' => 'Hutan hujan tropis, hutan pegunungan',
                'ancaman_utama' => 'Deforestasi, perburuan untuk bulu dan perdagangan hewan peliharaan.',
                'jumlah_terdeteksi' => 19,
            ],
            [
                'nama_ilmiah' => 'Catopuma temminckii',
                'nama_umum' => 'Kucing Emas Asia',
                'slug' => 'kucing-emas-asia',
                'status_konservasi' => 'Hampir Terancam',
                'deskripsi' => 'Kucing Emas Asia adalah kucing liar berukuran sedang yang jarang terlihat. Meskipun namanya kucing emas, warna bulunya bervariasi dari merah keemasan hingga coklat gelap. Merupakan predator soliter yang aktif siang dan malam.',
                'habitat' => 'Hutan primer dan sekunder, dari dataran rendah hingga 3000 mdpl',
                'ancaman_utama' => 'Hilangnya habitat, jebakan yang dipasang untuk satwa lain.',
                'jumlah_terdeteksi' => 15,
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
                'nama_ilmiah' => 'Manis javanica',
                'nama_umum' => 'Trenggiling Sunda',
                'slug' => 'trenggiling-sunda',
                'status_konservasi' => 'Kritis',
                'deskripsi' => 'Trenggiling Sunda adalah mamalia bersisik yang merupakan salah satu hewan paling banyak diperdagangkan secara ilegal di dunia. Sisiknya terbuat dari keratin (sama seperti kuku manusia) dan sayangnya dipercaya memiliki khasiat obat di beberapa budaya.',
                'habitat' => 'Hutan primer dan sekunder, perkebunan',
                'ancaman_utama' => 'Perdagangan ilegal sisik dan daging, hilangnya habitat.',
                'jumlah_terdeteksi' => 12,
            ],
            [
                'nama_ilmiah' => 'Arctictis binturong',
                'nama_umum' => 'Binturong',
                'slug' => 'binturong',
                'status_konservasi' => 'Rentan',
                'deskripsi' => 'Binturong atau Bearcat adalah mamalia arboreal dari keluarga Viverridae. Uniknya, binturong adalah salah satu dari sedikit mamalia yang memiliki ekor prehensil (dapat mencengkeram). Bau tubuhnya sering disamakan dengan popcorn mentega.',
                'habitat' => 'Hutan hujan tropis, kanopi hutan yang rapat',
                'ancaman_utama' => 'Deforestasi, perdagangan hewan peliharaan eksotis.',
                'jumlah_terdeteksi' => 22,
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
        ];

        foreach ($speciesData as $data) {
            Species::create($data);
        }
    }
}
