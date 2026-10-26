@extends('layouts.app')

@section('title', 'Hasil Deteksi')
@section('meta_description', 'Hasil analisis deteksi dan klasifikasi spesies satwa liar dari foto camera trap.')

@section('content')

    {{-- Section 1: Hasil Deteksi --}}
    <section class="bg-forest-900 pt-24 pb-12 lg:pt-32 lg:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-cream-100/50 mb-8">
                <a href="{{ url('/') }}" class="hover:text-cream-50 transition-colors duration-300">Beranda</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
                <a href="{{ url('/deteksi') }}" class="hover:text-cream-50 transition-colors duration-300">Deteksi</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
                <span class="text-cream-50">Hasil Analisis</span>
            </nav>

            <h1 class="text-3xl lg:text-4xl font-bold font-heading text-cream-50 mb-2">
                Hasil Deteksi & Klasifikasi
            </h1>
            <div class="flex items-center gap-4">
                <p class="text-cream-100/60 text-base">
                    Analisis ID: #{{ $detection->id }} &middot; {{ $detection->created_at->format('d M Y, H:i') }}
                </p>
                <a href="{{ route('deteksi.cetak', $detection->id) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-canopy-500 hover:bg-canopy-600 text-cream-50 text-sm font-medium rounded-lg transition-colors duration-300"
                   id="btn-cetak-pdf">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.25 7.034V3.375"/>
                    </svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </section>

    {{-- Foto + Result Card --}}
    <section class="py-10 lg:py-14 bg-cream-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                {{-- Foto yang diupload --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-cream-100">
                    <div class="px-5 py-3 bg-cream-50 border-b border-cream-100">
                        <p class="text-sm font-semibold text-forest-900">Foto Camera Trap</p>
                    </div>
                    <div class="p-4">
                        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-cream-100">
                            <img src="{{ asset('storage/' . $detection->foto_url) }}"
                                 alt="Foto camera trap"
                                 class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>

                {{-- Hasil klasifikasi --}}
                @if ($detection->species)
                    <x-result-card
                        :nama="$detection->species->nama_umum"
                        :nama-ilmiah="$detection->species->nama_ilmiah"
                        :confidence="$detection->confidence"
                        :status="$detection->species->status_konservasi"
                        :slug="$detection->species->slug"
                    />
                @else
                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-cream-100 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-text-500/30 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            <h3 class="text-xl font-heading font-bold text-text-900 mb-2">Spesies Tidak Terdeteksi</h3>
                            <p class="text-text-500 text-sm">Sistem tidak dapat mengidentifikasi spesies pada foto ini.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Section 2: Peta Habitat --}}
    @if ($detection->species)
        <section class="py-10 lg:py-14 bg-white" id="peta-habitat">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    title="Peta Habitat & Titik Konflik"
                    subtitle="Lokasi habitat alami {{ $detection->species->nama_umum }} di Sumatra dan titik-titik kejadian konflik manusia-satwa."
                    align="left"
                />

                <x-map-container
                    mapId="habitat-map"
                    :center="['lat' => $habitatCenter['lat'], 'lng' => $habitatCenter['lng']]"
                    :zoom="$habitatCenter['zoom']"
                    height="450px"
                    :markers="$conflictData->toArray()"
                    :habitatLabel="$habitatCenter['label']"
                    :geeData="$geeData"
                    :geeLegend="$geeLegend"
                />
            </div>
        </section>

        {{-- Section 3: Info Konflik --}}
        <section class="py-10 lg:py-14 bg-cream-50" id="info-konflik">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    title="Interaksi Negatif Satwa Liar"
                    subtitle="Data kejadian konflik manusia dan {{ $detection->species->nama_umum }} yang tercatat."
                    align="left"
                />

                {{-- Stats ringkas --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white rounded-xl p-5 border border-cream-100 shadow-sm">
                        <p class="text-3xl font-bold font-heading text-forest-900">{{ $conflictStats['total'] }}</p>
                        <p class="text-sm text-text-500 mt-1">Total Kejadian Tercatat</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-cream-100 shadow-sm">
                        <p class="text-lg font-bold font-heading text-forest-900 truncate">{{ $conflictStats['lokasi_terbanyak'] }}</p>
                        <p class="text-sm text-text-500 mt-1">Lokasi Paling Sering</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-cream-100 shadow-sm">
                        <p class="text-lg font-bold font-heading text-forest-900">{{ $conflictStats['terakhir'] }}</p>
                        <p class="text-sm text-text-500 mt-1">Kejadian Terakhir</p>
                    </div>
                </div>

                {{-- Tabel kejadian --}}
                @if ($conflictData->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-cream-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left" id="conflict-table">
                                <thead>
                                    <tr class="bg-cream-50 border-b border-cream-100">
                                        <th class="px-5 py-3 text-xs font-semibold text-text-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-text-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-text-500 uppercase tracking-wider">Deskripsi</th>
                                        <th class="px-5 py-3 text-xs font-semibold text-text-500 uppercase tracking-wider">Sumber</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-cream-100">
                                    @foreach ($conflictData as $conflict)
                                        <tr class="hover:bg-cream-50/50 transition-colors duration-200">
                                            <td class="px-5 py-4 text-sm font-medium text-forest-900 whitespace-nowrap">{{ $conflict['nama'] }}</td>
                                            <td class="px-5 py-4 text-sm text-text-500 whitespace-nowrap">{{ $conflict['tanggal'] }}</td>
                                            <td class="px-5 py-4 text-sm text-text-500 max-w-xs">{{ $conflict['deskripsi'] }}</td>
                                            <td class="px-5 py-4 text-sm text-earth-400 font-medium whitespace-nowrap">{{ $conflict['sumber'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-100 text-center">
                        <svg class="w-12 h-12 text-text-500/30 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                        </svg>
                        <p class="text-text-500 text-sm">Belum ada data konflik tercatat untuk spesies ini.</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- CTA Bawah --}}
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <a href="{{ url('/deteksi') }}"
               class="inline-flex items-center gap-2 px-8 py-3.5 bg-canopy-500 text-cream-50
                      font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                      transition-all duration-300 shadow-md hover:shadow-lg">
                Analisis Foto Lain
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </section>

@endsection
