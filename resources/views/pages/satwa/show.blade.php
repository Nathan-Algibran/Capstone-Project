@extends('layouts.app')

@section('title', $species->nama_umum)
@section('meta_description', $species->nama_umum . ' (' . $species->nama_ilmiah . ') — ' . Str::limit($species->deskripsi, 150))

@section('content')

    {{-- Hero --}}
    <section class="relative bg-forest-900 pt-20 lg:pt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                {{-- Info --}}
                <div>
                    {{-- Breadcrumb --}}
                    <nav class="flex items-center gap-2 text-sm text-cream-100/50 mb-6">
                        <a href="{{ url('/') }}" class="hover:text-cream-50 transition-colors duration-300">Beranda</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                        <a href="{{ url('/satwa') }}" class="hover:text-cream-50 transition-colors duration-300">Satwa Liar</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                        <span class="text-cream-50">{{ $species->nama_umum }}</span>
                    </nav>

                    {{-- Badge status --}}
                    @php
                        $statusColors = [
                            'Kritis' => 'bg-status-kritis text-white',
                            'Terancam Punah' => 'bg-status-terancam text-white',
                            'Rentan' => 'bg-status-rentan text-white',
                            'Hampir Terancam' => 'bg-status-hampir text-forest-900',
                            'Risiko Rendah' => 'bg-status-rendah text-white',
                            'Data Kurang' => 'bg-status-kurang text-white',
                        ];
                        $badgeClass = $statusColors[$species->status_konservasi] ?? 'bg-status-kurang text-white';
                    @endphp
                    <span class="inline-block px-4 py-1.5 text-sm font-semibold rounded-full {{ $badgeClass }} mb-4">
                        {{ $species->status_konservasi }}
                    </span>

                    <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-2">
                        {{ $species->nama_umum }}
                    </h1>
                    <p class="text-xl text-canopy-500 italic font-medium mb-6">
                        {{ $species->nama_ilmiah }}
                    </p>

                    {{-- Quick stats --}}
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-cream-50/10 backdrop-blur-sm rounded-xl px-5 py-3 border border-cream-50/10">
                            <p class="text-2xl font-bold font-heading text-cream-50">{{ $species->jumlah_terdeteksi }}</p>
                            <p class="text-xs text-cream-100/60 mt-0.5">Terdeteksi Sistem</p>
                        </div>
                        <div class="bg-cream-50/10 backdrop-blur-sm rounded-xl px-5 py-3 border border-cream-50/10">
                            <p class="text-2xl font-bold font-heading text-cream-50">{{ $species->conflict_incidents_count ?? 0 }}</p>
                            <p class="text-xs text-cream-100/60 mt-0.5">Kejadian Konflik</p>
                        </div>
                    </div>
                </div>

                {{-- Foto --}}
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                        @if ($species->foto_url)
                            <img src="{{ $species->foto_url }}" alt="{{ $species->nama_umum }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-forest-700 to-canopy-500 flex items-center justify-center">
                                <svg class="w-24 h-24 text-cream-50/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Decorative --}}
                    <div class="absolute -z-10 -bottom-3 -right-3 w-full h-full bg-canopy-500/20 rounded-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Detail Info --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Deskripsi (lebar) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Deskripsi --}}
                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-cream-100">
                        <h2 class="text-2xl font-bold font-heading text-forest-900 mb-4">Tentang {{ $species->nama_umum }}</h2>
                        <p class="text-text-500 leading-relaxed">
                            {{ $species->deskripsi ?? 'Deskripsi belum tersedia.' }}
                        </p>
                    </div>

                    {{-- Ancaman --}}
                    @if ($species->ancaman_utama)
                        <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-cream-100">
                            <h2 class="text-2xl font-bold font-heading text-forest-900 mb-4">Ancaman Utama</h2>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 shrink-0 bg-alert-500/10 rounded-lg flex items-center justify-center mt-0.5">
                                    <svg class="w-5 h-5 text-alert-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                    </svg>
                                </div>
                                <p class="text-text-500 leading-relaxed">{{ $species->ancaman_utama }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar info --}}
                <div class="space-y-6">
                    {{-- Habitat --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-cream-100">
                        <h3 class="text-lg font-bold font-heading text-forest-900 mb-3">Habitat</h3>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 shrink-0 bg-canopy-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.877.293a1.125 1.125 0 01-1.369-.502l-.128-.256a2.865 2.865 0 00-1.318-1.318"/>
                                </svg>
                            </div>
                            <p class="text-text-500 text-sm leading-relaxed">
                                {{ $species->habitat ?? 'Data habitat belum tersedia.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Status Konservasi --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-cream-100">
                        <h3 class="text-lg font-bold font-heading text-forest-900 mb-3">Status Konservasi</h3>
                        <div class="flex items-center gap-3">
                            <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full {{ $badgeClass }}">
                                {{ $species->status_konservasi }}
                            </span>
                        </div>
                        <p class="text-text-500 text-xs mt-3">Berdasarkan klasifikasi IUCN Red List</p>
                    </div>

                    {{-- CTA Deteksi --}}
                    <div class="bg-gradient-to-br from-forest-900 to-forest-700 rounded-2xl p-6 text-center">
                        <p class="text-cream-100/70 text-sm mb-4">
                            Punya foto camera trap? Coba deteksi spesies secara otomatis.
                        </p>
                        <a href="{{ url('/deteksi') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-canopy-500 text-cream-50
                                  font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                                  transition-all duration-300 text-sm">
                            Coba Deteksi
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Spesies Lainnya --}}
    @if ($relatedSpecies->isNotEmpty())
        <section class="py-12 lg:py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    title="Spesies Lainnya"
                    subtitle="Jelajahi spesies satwa liar lain yang dapat dideteksi oleh sistem."
                />

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedSpecies as $sp)
                        <x-species-card
                            :nama="$sp->nama_umum"
                            :nama-ilmiah="$sp->nama_ilmiah"
                            :status="$sp->status_konservasi"
                            :foto="$sp->foto_url"
                            :slug="$sp->slug"
                        />
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ url('/satwa') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-forest-900 text-cream-50
                              font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                              transition-all duration-300 shadow-md">
                        Lihat Semua Spesies
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection
