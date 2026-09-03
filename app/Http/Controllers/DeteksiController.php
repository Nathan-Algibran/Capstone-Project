<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use App\Models\Species;
use App\Models\ConflictIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeteksiController extends Controller
{
    public function index()
    {
        return view('pages.deteksi.index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:10240',
        ]);

        // Simpan foto
        $path = $request->file('foto')->store('detections', 'public');

        // Dummy: pilih spesies acak dan confidence acak (AI belum terhubung)
        $species = Species::inRandomOrder()->first();
        $confidence = rand(7500, 9800) / 100; // 75.00 - 98.00

        $detection = Detection::create([
            'species_id' => $species?->id,
            'foto_url' => $path,
            'confidence' => $confidence,
            'lokasi_lat' => null,
            'lokasi_lng' => null,
            'lokasi_nama' => null,
        ]);

        return redirect()->route('deteksi.hasil', $detection->id);
    }

    public function hasil($id)
    {
        $detection = Detection::with('species')->findOrFail($id);

        // Data konflik untuk spesies yang terdeteksi
        $conflictData = [];
        $conflictStats = [];

        if ($detection->species) {
            $conflicts = ConflictIncident::where('species_id', $detection->species_id)
                ->orderBy('tanggal', 'desc')
                ->get();

            // Format data untuk Leaflet map (JSON)
            $conflictData = $conflicts->map(function ($c) {
                return [
                    'lat' => (float) $c->lokasi_lat,
                    'lng' => (float) $c->lokasi_lng,
                    'nama' => $c->lokasi_nama,
                    'tanggal' => $c->tanggal->format('d M Y'),
                    'sumber' => $c->sumber,
                    'deskripsi' => $c->deskripsi,
                ];
            })->values();

            // Statistik konflik
            $conflictStats = [
                'total' => $conflicts->count(),
                'lokasi_terbanyak' => $conflicts->groupBy('lokasi_nama')
                    ->sortByDesc(fn ($group) => $group->count())
                    ->keys()
                    ->first() ?? 'Belum ada data',
                'terakhir' => $conflicts->first()?->tanggal->format('d M Y') ?? 'Belum ada data',
            ];
        }

        // Area habitat (koordinat pusat peta berdasarkan spesies)
        $habitatCenter = $this->getHabitatCenter($detection->species?->slug);

        return view('pages.deteksi.hasil', compact(
            'detection',
            'conflictData',
            'conflictStats',
            'habitatCenter',
        ));
    }

    /**
     * Koordinat pusat habitat untuk tiap spesies di Sumatra.
     */
    private function getHabitatCenter(?string $slug): array
    {
        $habitats = [
            'harimau-sumatra'    => ['lat' => -1.5, 'lng' => 101.5, 'zoom' => 7, 'label' => 'Hutan hujan tropis Sumatra'],
            'gajah-sumatra'      => ['lat' => -2.0, 'lng' => 102.0, 'zoom' => 7, 'label' => 'Dataran rendah Sumatra Tengah & Selatan'],
            'badak-sumatra'      => ['lat' => -4.5, 'lng' => 104.5, 'zoom' => 8, 'label' => 'Way Kambas & Bukit Barisan Selatan'],
            'orangutan-sumatra'  => ['lat' => 3.5, 'lng' => 97.8, 'zoom' => 8, 'label' => 'Ekosistem Leuser, Aceh & Sumut'],
            'tapir-asia'         => ['lat' => -1.0, 'lng' => 101.0, 'zoom' => 7, 'label' => 'Hutan primer Sumatra Barat & Jambi'],
            'beruang-madu'       => ['lat' => -0.5, 'lng' => 101.5, 'zoom' => 7, 'label' => 'Hutan tropis Sumatra'],
            'macan-dahan'        => ['lat' => -2.0, 'lng' => 101.5, 'zoom' => 7, 'label' => 'Hutan pegunungan Kerinci Seblat'],
            'kucing-emas-asia'   => ['lat' => -1.5, 'lng' => 101.0, 'zoom' => 7, 'label' => 'Hutan primer & sekunder Sumatra'],
            'rusa-sambar'        => ['lat' => -1.0, 'lng' => 102.0, 'zoom' => 7, 'label' => 'Hutan & padang rumput Sumatra'],
            'babi-hutan'         => ['lat' => -1.5, 'lng' => 102.0, 'zoom' => 6, 'label' => 'Tersebar luas di Sumatra'],
            'kijang-muntjak'     => ['lat' => -1.0, 'lng' => 101.5, 'zoom' => 7, 'label' => 'Hutan hujan & semak belukar Sumatra'],
            'trenggiling-sunda'  => ['lat' => -2.0, 'lng' => 102.0, 'zoom' => 7, 'label' => 'Hutan primer Sumatra'],
            'binturong'          => ['lat' => -0.5, 'lng' => 101.0, 'zoom' => 7, 'label' => 'Kanopi hutan tropis Sumatra'],
            'landak-raya'        => ['lat' => -1.5, 'lng' => 101.5, 'zoom' => 7, 'label' => 'Hutan & area berbatu Sumatra'],
        ];

        return $habitats[$slug] ?? ['lat' => -0.5, 'lng' => 101.5, 'zoom' => 6, 'label' => 'Pulau Sumatra'];
    }
}
