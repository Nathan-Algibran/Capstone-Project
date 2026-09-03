<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;

class SatwaController extends Controller
{
    public function index(Request $request)
    {
        $query = Species::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_umum', 'like', "%{$search}%")
                  ->orWhere('nama_ilmiah', 'like', "%{$search}%");
            });
        }

        // Filter by status konservasi
        if ($request->filled('status')) {
            $query->where('status_konservasi', $request->input('status'));
        }

        $species = $query->orderBy('nama_umum')->get();

        $statusList = Species::select('status_konservasi')
            ->distinct()
            ->orderBy('status_konservasi')
            ->pluck('status_konservasi');

        return view('pages.satwa.index', compact('species', 'statusList'));
    }

    public function show(Species $species)
    {
        $species->loadCount(['detections', 'conflictIncidents']);

        // Ambil spesies lain untuk section "Spesies Lainnya"
        $relatedSpecies = Species::where('id', '!=', $species->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('pages.satwa.show', compact('species', 'relatedSpecies'));
    }
}
