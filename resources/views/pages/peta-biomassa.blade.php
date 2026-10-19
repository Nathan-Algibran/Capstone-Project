@extends('layouts.app')

@section('title', 'Peta Biomas & Zona Konflik')
@section('meta_description', 'Peta interaktif wilayah Sumatra menampilkan tutupan lahan MapBiomas dan titik-titik kejadian konflik manusia-satwa liar. Jelajahi data berdasarkan spesies.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-forest-900 pt-24 pb-12 lg:pt-32 lg:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-4">
                Peta Biomassa & Zona Konflik
            </h1>
            <p class="text-cream-100/70 text-lg max-w-2xl">
                Jelajahi peta interaktif wilayah Sumatra dengan overlay tutupan lahan
                MapBiomas Indonesia. Lihat titik-titik kejadian konflik manusia-satwa liar berdasarkan spesies.
            </p>
        </div>
    </section>

    {{-- Filter --}}
    <section class="bg-cream-50 border-b border-cream-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" action="{{ url('/peta-biomassa') }}" class="flex flex-col sm:flex-row gap-3 items-end"
                  id="peta-filter-form">

                {{-- Filter Spesies --}}
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-text-500 uppercase tracking-wider mb-1.5">
                        Filter Spesies
                    </label>
                    <div class="relative">
                        <select name="species"
                                class="appearance-none w-full px-4 py-2.5 pr-10 bg-white border border-cream-100
                                       rounded-xl text-text-900 text-sm focus:outline-none focus:ring-2
                                       focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300"
                                id="peta-species-filter"
                                onchange="this.form.submit()">
                            <option value="">Semua Spesies ({{ $mapData->count() }} kejadian tahun {{ $year }})</option>
                            @foreach ($speciesList as $sp)
                                <option value="{{ $sp->id }}" {{ request('species') == $sp->id ? 'selected' : '' }}>
                                    {{ $sp->nama_umum }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-text-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Filter Tahun MapBiomas --}}
                <div class="w-full sm:w-40">
                    <label class="block text-xs font-semibold text-text-500 uppercase tracking-wider mb-1.5">
                        Tahun Peta
                    </label>
                    <div class="relative">
                        <select name="year"
                                class="appearance-none w-full px-4 py-2.5 pr-10 bg-white border border-cream-100
                                       rounded-xl text-text-900 text-sm focus:outline-none focus:ring-2
                                       focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300"
                                id="peta-year-filter"
                                onchange="this.form.submit()">
                            @for ($y = 2024; $y >= 1990; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-text-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                @if (request('species') || request('year'))
                    <a href="{{ url('/peta-biomassa') }}"
                       class="px-5 py-2.5 bg-cream-100 text-text-900 text-sm font-semibold rounded-xl
                              hover:bg-cream-50 border border-cream-100 transition-all duration-300"
                       id="peta-reset-btn">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- Map --}}
    <section class="py-8 lg:py-12 bg-cream-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-map-container
                mapId="exploration-map"
                :center="['lat' => -0.5, 'lng' => 101.5]"
                :zoom="6"
                height="600px"
                :markers="$mapData->toArray()"
                habitatLabel="Pulau Sumatra — Tutupan Lahan & Zona Konflik"
                :geeData="$geeData"
                :geeLegend="$geeLegend"
                :clusterCircles="$clusterCircles"
            />

            {{-- Ringkasan --}}
            <div class="mt-6 grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl p-4 border border-cream-100 shadow-sm">
                    <p class="text-2xl font-bold font-heading text-forest-900">{{ $mapData->count() }}</p>
                    <p class="text-xs text-text-500 mt-1">Titik Konflik Ditampilkan</p>
                </div>
                <div class="bg-white rounded-xl p-4 border border-cream-100 shadow-sm">
                    <p class="text-2xl font-bold font-heading text-forest-900">{{ $mapData->unique('nama')->count() }}</p>
                    <p class="text-xs text-text-500 mt-1">Lokasi Berbeda</p>
                </div>
                <div class="bg-white rounded-xl p-4 border border-cream-100 shadow-sm">
                    <p class="text-2xl font-bold font-heading text-forest-900">{{ $mapData->unique('spesies')->count() }}</p>
                    <p class="text-xs text-text-500 mt-1">Spesies Terlibat</p>
                </div>
                <div class="bg-white rounded-xl p-4 border border-cream-100 shadow-sm">
                    <p class="text-2xl font-bold font-heading text-forest-900">{{ count($clusterCircles) }}</p>
                    <p class="text-xs text-text-500 mt-1">Zona Cluster Konflik</p>
                </div>
                <div class="bg-white rounded-xl p-4 border border-cream-100 shadow-sm text-center">
                    <a href="{{ url('/deteksi') }}"
                       class="inline-flex items-center gap-1.5 text-canopy-500 font-semibold text-sm
                              hover:gap-2.5 transition-all duration-300">
                        Coba Deteksi Foto
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- GEE Status Banner --}}
            @if (!($geeData['available'] ?? false))
                <div class="mt-4 bg-earth-400/10 border border-earth-400/30 rounded-xl px-5 py-3 flex items-start gap-3">
                    <svg class="w-5 h-5 text-earth-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-earth-400">Layer MapBiomas Tidak Tersedia</p>
                        <p class="text-xs text-text-500 mt-0.5">
                            GEE Service belum aktif. Jalankan <code class="text-xs bg-cream-100 px-1.5 py-0.5 rounded">uvicorn main:app --port 8003</code> di folder <code class="text-xs bg-cream-100 px-1.5 py-0.5 rounded">scripts/gee_service/</code> untuk mengaktifkan overlay peta tutupan lahan.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
