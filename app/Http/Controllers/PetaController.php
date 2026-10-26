<?php

namespace App\Http\Controllers;

use App\Models\ConflictIncident;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $speciesList = Species::orderBy('nama_umum')->get(['id', 'nama_umum', 'slug']);

        // Filter by species
        $query = ConflictIncident::with('species');

        if ($request->filled('species')) {
            $query->where('species_id', $request->input('species'));
        }

        // Ambil tahun peta yang dipilih
        $year = (int) $request->input('year', 2024);

        // Filter konflik berdasarkan tahun yang dipilih
        $query->whereYear('tanggal', $year);

        $conflicts = $query->orderBy('tanggal', 'desc')->get();

        // Format data untuk Leaflet — conflict markers (merah)
        $mapData = $conflicts->map(function ($c) {
            return [
                'lat' => (float) $c->lokasi_lat,
                'lng' => (float) $c->lokasi_lng,
                'nama' => $c->lokasi_nama,
                'tanggal' => $c->tanggal->format('d M Y'),
                'sumber' => $c->sumber,
                'deskripsi' => $c->deskripsi,
                'spesies' => $c->species?->nama_umum ?? 'Tidak diketahui',
                'land_class' => $c->land_class_label,
                'cluster_id' => $c->cluster_id,
            ];
        })->values();

        // Hitung cluster circles (pusat & radius per cluster)
        $clusterCircles = $this->calculateClusterCircles($conflicts);

        // Ambil tile URL dari GEE Service
        $geeData = $this->fetchGeeTileUrl($year);

        // Ambil legenda dari GEE Service
        $geeLegend = $this->fetchGeeLegend();

        return view('pages.peta-biomassa', compact(
            'speciesList',
            'mapData',
            'conflicts',
            'clusterCircles',
            'geeData',
            'geeLegend',
            'year',
        ));
    }

    /**
     * Ambil tile URL dari GEE Python Service.
     * Di-cache selama 50 menit (tile GEE expired ~1 jam).
     */
    public function fetchGeeTileUrl(int $year = 2024): array
    {
        $cacheKey = "gee_tile_url_{$year}";

        // Cek cache dulu — hanya cache hasil sukses
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        try {
            $apiUrl = config('services.gee_api.url');
            $response = Http::timeout(30)->get("{$apiUrl}/tile-url", [
                'year' => $year,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('GEE tile URL berhasil diambil', ['year' => $year]);
                $result = [
                    'available' => true,
                    'tile_url' => $data['tile_url'],
                    'year' => $data['year'],
                    'attribution' => $data['attribution'] ?? 'MapBiomas Indonesia',
                ];

                // Cache hanya hasil sukses (50 menit, tile GEE expired ~1 jam)
                Cache::put($cacheKey, $result, 3000);
                return $result;
            }

            Log::warning('GEE Service mengembalikan error', [
                'status' => $response->status(),
            ]);
        } catch (\Exception $e) {
            Log::warning('GEE Service tidak tersedia: ' . $e->getMessage());
        }

        // Hasil gagal TIDAK di-cache — supaya retry otomatis saat di-refresh
        return [
            'available' => false,
            'tile_url' => null,
            'year' => $year,
            'attribution' => null,
        ];
    }

    /**
     * Ambil legenda kelas MapBiomas dari GEE Service.
     * Di-cache selama 24 jam (jarang berubah).
     */
    private function fetchGeeLegend(): array
    {
        return Cache::remember('gee_mapbiomas_legend', 86400, function () {
            try {
                $apiUrl = config('services.gee_api.url');
                $response = Http::timeout(10)->get("{$apiUrl}/legend");

                if ($response->successful()) {
                    return $response->json()['legend'] ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('Gagal ambil legenda GEE: ' . $e->getMessage());
            }

            // Fallback: legenda minimal hardcoded
            return [
                ['class_id' => 3, 'label' => 'Formasi Hutan', 'color' => '#1f8d49', 'tipe' => 'habitat'],
                ['class_id' => 5, 'label' => 'Mangrove', 'color' => '#04381d', 'tipe' => 'habitat'],
                ['class_id' => 9, 'label' => 'Hutan Tanaman', 'color' => '#7a5900', 'tipe' => 'konflik'],
                ['class_id' => 35, 'label' => 'Kelapa Sawit', 'color' => '#c71585', 'tipe' => 'konflik'],
                ['class_id' => 24, 'label' => 'Perkotaan', 'color' => '#d4271e', 'tipe' => 'konflik'],
                ['class_id' => 33, 'label' => 'Badan Air', 'color' => '#2532e4', 'tipe' => 'habitat'],
            ];
        });
    }

    /**
     * Hitung pusat & radius setiap cluster DBSCAN untuk ditampilkan sebagai circle di peta.
     */
    private function calculateClusterCircles($conflicts): array
    {
        $clustered = $conflicts->filter(fn ($c) => $c->cluster_id >= 0)->groupBy('cluster_id');

        return $clustered->map(function ($group, $clusterId) {
            $lats = $group->pluck('lokasi_lat')->map(fn ($v) => (float) $v);
            $lngs = $group->pluck('lokasi_lng')->map(fn ($v) => (float) $v);

            $centerLat = $lats->avg();
            $centerLng = $lngs->avg();

            // Hitung radius (max jarak dari pusat ke titik terjauh, dalam meter)
            $maxDist = 0;
            foreach ($group as $c) {
                $dist = $this->haversineDistance(
                    $centerLat, $centerLng,
                    (float) $c->lokasi_lat, (float) $c->lokasi_lng
                );
                $maxDist = max($maxDist, $dist);
            }

            // Radius minimal 500m, tambah 20% padding
            $radius = max(500, $maxDist * 1.2);

            return [
                'cluster_id' => $clusterId,
                'center_lat' => round($centerLat, 6),
                'center_lng' => round($centerLng, 6),
                'radius' => round($radius),
                'count' => $group->count(),
            ];
        })->values()->toArray();
    }

    /**
     * Hitung jarak haversine antara dua titik (return dalam meter).
     */
    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
    /**
     * Export data konflik ke CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = ConflictIncident::with('species');

        if ($request->filled('species')) {
            $query->where('species_id', $request->input('species'));
        }

        $year = (int) $request->input('year', 2024);
        $query->whereYear('tanggal', $year);

        $conflicts = $query->orderBy('tanggal', 'desc')->get();

        $filename = "konflik_satwa_{$year}.csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($conflicts) {
            $file = fopen('php://output', 'w');

            // BOM untuk Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, [
                'No',
                'Spesies',
                'Nama Ilmiah',
                'Tanggal',
                'Lokasi',
                'Latitude',
                'Longitude',
                'Kelas Lahan',
                'Sumber',
                'Deskripsi',
            ]);

            foreach ($conflicts as $i => $c) {
                fputcsv($file, [
                    $i + 1,
                    $c->species?->nama_umum ?? 'Tidak diketahui',
                    $c->species?->nama_ilmiah ?? '-',
                    $c->tanggal->format('Y-m-d'),
                    $c->lokasi_nama,
                    $c->lokasi_lat,
                    $c->lokasi_lng,
                    $c->land_class_label ?? '-',
                    $c->sumber,
                    $c->deskripsi,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
