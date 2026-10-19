<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use App\Models\Species;
use App\Models\ConflictIncident;
use App\Http\Controllers\PetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $file = $request->file('foto');

        // Simpan foto ke storage (sama seperti sebelumnya)
        $path = $file->store('detections', 'public');

        // --- Panggil API Python (FastAPI + MegaDetector + ResNet) ---
        $apiResult = $this->callDetectionApi($file);

        $species = null;
        $confidence = null;

        if ($apiResult !== null && count($apiResult['detections']) > 0) {
            // Ambil deteksi dengan classification_confidence tertinggi,
            // abaikan yang "tidak_teridentifikasi"
            $bestDetection = collect($apiResult['detections'])
                ->where('species', '!=', 'tidak_teridentifikasi')
                ->sortByDesc('classification_confidence')
                ->first();

            if ($bestDetection) {
                $species = $this->findSpeciesByModelClass($bestDetection['species']);
                $confidence = $bestDetection['classification_confidence'];

                if ($species) {
                    $species->increment('jumlah_terdeteksi');
                }
            }
        }

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

    /**
     * Kirim foto ke API Python (FastAPI) untuk deteksi + klasifikasi.
     * Return null kalau API gagal dihubungi (misal service belum jalan),
     * supaya sistem tetap jalan (fallback ke "tidak teridentifikasi")
     * daripada error total.
     */
    private function callDetectionApi($file): ?array
    {
        $apiUrl = config('services.detection_api.url');

        try {
            $response = Http::timeout(30)
                ->attach(
                    'file',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )
                ->post($apiUrl . '/predict');

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Detection API mengembalikan status gagal', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi Detection API: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Cocokkan nama kelas dari model klasifikasi (contoh: "elephas_maximus")
     * dengan record di tabel species berdasarkan nama_ilmiah.
     *
     * Konversi: "elephas_maximus" -> "elephas maximus" -> dicocokkan
     * case-insensitive dengan kolom nama_ilmiah (contoh: "Elephas maximus").
     */
    private function findSpeciesByModelClass(string $modelClassName): ?Species
    {
        $normalized = strtolower(str_replace('_', ' ', $modelClassName));

        // Pakai LIKE 'genus species%' supaya tetap cocok meski di database
        // ditulis dengan nama subspesies lengkap, misal:
        // classifier: "panthera tigris" -> cocok dengan DB: "Panthera tigris sumatrae"
        return Species::whereRaw('LOWER(nama_ilmiah) LIKE ?', [$normalized . '%'])->first();
    }

    public function hasil($id)
    {
        $detection = Detection::with('species')->findOrFail($id);

        $conflictData = [];
        $conflictStats = [];

        if ($detection->species) {
            $conflicts = ConflictIncident::where('species_id', $detection->species_id)
                ->orderBy('tanggal', 'desc')
                ->get();

            $conflictData = $conflicts->map(function ($c) {
                return [
                    'lat' => (float) $c->lokasi_lat,
                    'lng' => (float) $c->lokasi_lng,
                    'nama' => $c->lokasi_nama,
                    'tanggal' => $c->tanggal->format('d M Y'),
                    'sumber' => $c->sumber,
                    'deskripsi' => $c->deskripsi,
                    'land_class' => $c->land_class_label,
                    'cluster_id' => $c->cluster_id,
                ];
            })->values();

            $conflictStats = [
                'total' => $conflicts->count(),
                'lokasi_terbanyak' => $conflicts->groupBy('lokasi_nama')
                    ->sortByDesc(fn ($group) => $group->count())
                    ->keys()
                    ->first() ?? 'Belum ada data',
                'terakhir' => $conflicts->first()?->tanggal->format('d M Y') ?? 'Belum ada data',
            ];
        }

        $habitatCenter = $this->getHabitatCenter($detection->species?->slug);

        // Ambil MapBiomas GEE tile URL & legenda
        $petaController = new PetaController();
        $geeData = $petaController->fetchGeeTileUrl(2024);
        $geeLegend = Cache::remember('gee_mapbiomas_legend', 86400, function () {
            try {
                $apiUrl = config('services.gee_api.url');
                $response = Http::timeout(10)->get("{$apiUrl}/legend");
                if ($response->successful()) {
                    return $response->json()['legend'] ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('Gagal ambil legenda GEE: ' . $e->getMessage());
            }
            return [];
        });

        return view('pages.deteksi.hasil', compact(
            'detection',
            'conflictData',
            'conflictStats',
            'habitatCenter',
            'geeData',
            'geeLegend',
        ));
    }

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