<?php

namespace App\Http\Controllers;

use App\Models\ConflictIncident;
use App\Models\Detection;
use App\Models\Species;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $stats = [
            'spesies_count'  => Species::count(),
            'deteksi_count'  => Detection::count(),
            'konflik_count'  => ConflictIncident::count(),
        ];

        // 6 spesies unggulan: prioritaskan yang Kritis, lalu jumlah terdeteksi tertinggi
        $spesiesUnggulan = Species::orderByRaw("FIELD(status_konservasi, 'Kritis', 'Terancam Punah', 'Rentan', 'Hampir Terancam', 'Risiko Rendah')")
            ->orderBy('jumlah_terdeteksi', 'desc')
            ->take(6)
            ->get();

        return view('pages.home', compact('stats', 'spesiesUnggulan'));
    }

    public function tentang()
    {
        return view('pages.tentang');
    }

    public function kontak()
    {
        return view('pages.kontak');
    }
}
