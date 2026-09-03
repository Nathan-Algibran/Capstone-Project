<?php

namespace App\Http\Controllers;

use App\Models\ConflictIncident;
use App\Models\Species;
use Illuminate\Http\Request;

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

        $conflicts = $query->orderBy('tanggal', 'desc')->get();

        // Format data untuk Leaflet
        $mapData = $conflicts->map(function ($c) {
            return [
                'lat' => (float) $c->lokasi_lat,
                'lng' => (float) $c->lokasi_lng,
                'nama' => $c->lokasi_nama,
                'tanggal' => $c->tanggal->format('d M Y'),
                'sumber' => $c->sumber,
                'deskripsi' => $c->deskripsi,
                'spesies' => $c->species?->nama_umum ?? 'Tidak diketahui',
            ];
        })->values();

        return view('pages.peta-biomassa', compact('speciesList', 'mapData', 'conflicts'));
    }
}
