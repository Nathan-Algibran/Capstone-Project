<?php

use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\SatwaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

// Satwa
Route::get('/satwa', [SatwaController::class, 'index'])->name('satwa.index');
Route::get('/satwa/{species}', [SatwaController::class, 'show'])->name('satwa.show');

// Deteksi
Route::get('/deteksi', [DeteksiController::class, 'index'])->name('deteksi.index');
Route::post('/deteksi/upload', [DeteksiController::class, 'upload'])->name('deteksi.upload');
Route::get('/deteksi/hasil/{id}', [DeteksiController::class, 'hasil'])->name('deteksi.hasil');
Route::get('/deteksi/hasil/{id}/cetak', [DeteksiController::class, 'cetak'])->name('deteksi.cetak');

// Peta Biomassa
Route::get('/peta-biomassa', [PetaController::class, 'index'])->name('peta.index');
Route::get('/peta-biomassa/export-csv', [PetaController::class, 'exportCsv'])->name('peta.exportCsv');

// Halaman Statis
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
