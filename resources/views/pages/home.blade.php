@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'SIMAKSI — Sistem Deteksi & Analisis Konflik Satwa Liar Sumatra. Identifikasi spesies dari foto camera trap dengan kecerdasan buatan.')

@section('content')

    {{-- 1. Hero Section --}}
    <x-hero-section />

    {{-- 2. Statistik Ringkas --}}
    <section class="py-16 lg:py-20 bg-white" id="statistik">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <x-stat-card value="{{ $stats['spesies_count'] }}" label="Spesies Terdaftar" suffix="" />
                <x-stat-card value="{{ $stats['deteksi_count'] }}" label="Foto Teranalisis" suffix="+" />
                <x-stat-card value="92" label="Akurasi Model" suffix="%" />
                <x-stat-card value="{{ $stats['konflik_count'] }}" label="Kejadian Konflik Tercatat" suffix="" />
            </div>
        </div>
    </section>

    {{-- 3. Spesies Unggulan --}}
    <section class="py-16 lg:py-20 bg-cream-50" id="spesies-unggulan">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Spesies yang Terdeteksi Sistem"
                subtitle="Sistem kami mampu mengidentifikasi berbagai spesies satwa liar Sumatra dari foto camera trap menggunakan model deep learning."
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($spesiesUnggulan as $sp)
                    <x-species-card
                        :nama="$sp->nama_umum"
                        :nama-ilmiah="$sp->nama_ilmiah"
                        :status="$sp->status_konservasi"
                        :slug="$sp->slug"
                        :foto="file_exists(public_path('images/species/' . $sp->slug . '.png')) ? asset('images/species/' . $sp->slug . '.png') : null"
                    />
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/satwa') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-forest-900 text-cream-50
                          font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                          transition-all duration-300 shadow-md hover:shadow-lg">
                    Lihat Semua Spesies
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- 4. Tentang Fitur Utama (2 kolom) --}}
    <section class="py-16 lg:py-20 bg-white" id="tentang-fitur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Fitur Utama"
                subtitle="Dua fitur inti yang mendukung upaya konservasi satwa liar di Sumatra."
            />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                {{-- Fitur 1: Deteksi Foto --}}
                <div class="group relative bg-gradient-to-br from-forest-900 to-forest-700 rounded-2xl overflow-hidden
                            shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="p-8 lg:p-10">
                        <div class="w-14 h-14 bg-canopy-500/20 rounded-xl flex items-center justify-center mb-6
                                    group-hover:bg-canopy-500/30 transition-colors duration-300">
                            <svg class="w-7 h-7 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold font-heading text-cream-50 mb-3">Deteksi & Klasifikasi Satwa</h3>
                        <p class="text-cream-100/70 leading-relaxed mb-6">
                            Upload foto camera trap dan sistem AI kami akan secara otomatis mendeteksi
                            keberadaan satwa liar serta mengklasifikasikan spesiesnya dengan tingkat
                            akurasi tinggi menggunakan model deep learning.
                        </p>
                        <a href="{{ url('/deteksi') }}"
                           class="inline-flex items-center gap-2 text-canopy-500 font-semibold
                                  group-hover:gap-3 transition-all duration-300">
                            Mulai Deteksi
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Fitur 2: Peta Biomassa --}}
                <div class="group relative bg-gradient-to-br from-forest-900 to-forest-700 rounded-2xl overflow-hidden
                            shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="p-8 lg:p-10">
                        <div class="w-14 h-14 bg-earth-400/20 rounded-xl flex items-center justify-center mb-6
                                    group-hover:bg-earth-400/30 transition-colors duration-300">
                            <svg class="w-7 h-7 text-earth-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold font-heading text-cream-50 mb-3">MapBiomas & Zona Konflik</h3>
                        <p class="text-cream-100/70 leading-relaxed mb-6">
                            Jelajahi peta interaktif wilayah Sumatra yang menampilkan data tutupan
                            hutan, biomassa, serta titik-titik kejadian konflik manusia-satwa.
                            Analisis pola dan prediksi zona risiko konflik.
                        </p>
                        <a href="{{ url('/peta-biomassa') }}"
                           class="inline-flex items-center gap-2 text-earth-400 font-semibold
                                  group-hover:gap-3 transition-all duration-300">
                            Buka Peta
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 5. Tentang Project --}}
    <section class="py-16 lg:py-20 bg-cream-100" id="tentang-project">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                {{-- Kiri: Teks --}}
                <div>
                    <x-section-heading
                        title="Tentang SIMAKSI"
                        subtitle=""
                        align="left"
                    />
                    <div class="space-y-4 text-text-500 leading-relaxed">
                        <p>
                            SIMAKSI (Sistem Deteksi & Analisis Konflik Satwa Liar Sumatra) adalah
                            capstone project yang mengintegrasikan kecerdasan buatan dengan data
                            ekologi untuk mendukung upaya konservasi di Pulau Sumatra.
                        </p>
                        <p>
                            Menggunakan model deep learning (MegaDetector + ResNet), sistem ini
                            mampu mendeteksi dan mengklasifikasikan spesies satwa liar dari
                            foto camera trap secara otomatis. Data yang diperoleh kemudian
                            dianalisis bersama data biomassa dan tutupan hutan untuk
                            mengidentifikasi pola konflik manusia-satwa.
                        </p>
                        <p>
                            Project ini bertujuan memberikan alat bantu berbasis teknologi bagi
                            peneliti, petugas taman nasional/BKSDA, dan masyarakat yang peduli
                            terhadap kelestarian satwa liar Sumatra.
                        </p>
                    </div>
                    <a href="{{ url('/tentang') }}"
                       class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-forest-900 text-cream-50
                              font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                              transition-all duration-300 shadow-md">
                        Selengkapnya
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                {{-- Kanan: Visual --}}
                <div class="relative">
                    <div class="bg-gradient-to-br from-forest-700 to-canopy-500 rounded-2xl p-8 lg:p-10 shadow-lg">
                        <div class="space-y-6">
                            @php
                                $steps = [
                                    ['icon' => 'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5', 'title' => 'Upload Foto', 'desc' => 'Unggah foto camera trap ke sistem'],
                                    ['icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z', 'title' => 'Deteksi AI', 'desc' => 'Model AI mendeteksi dan mengklasifikasi'],
                                    ['icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'title' => 'Analisis Hasil', 'desc' => 'Lihat spesies, confidence, dan analisis'],
                                ];
                            @endphp

                            @foreach ($steps as $index => $step)
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 shrink-0 bg-cream-50/15 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-cream-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-cream-50 font-semibold">{{ $step['title'] }}</h4>
                                        <p class="text-cream-100/60 text-sm mt-1">{{ $step['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Decorative blur --}}
                    <div class="absolute -z-10 -top-4 -right-4 w-full h-full bg-earth-400/20 rounded-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA akhir halaman (pengganti CTA donasi wildnet.org) --}}
    <section class="py-16 lg:py-20 bg-forest-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-canopy-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-earth-400/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold font-heading text-cream-50 mb-4">
                Siap Menganalisis Foto Camera Trap?
            </h2>
            <p class="text-cream-100/70 text-lg mb-8 max-w-xl mx-auto">
                Upload foto Anda sekarang dan biarkan sistem AI kami mendeteksi spesies satwa liar secara otomatis.
            </p>
            <a href="{{ url('/deteksi') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-canopy-500 text-cream-50 text-lg
                      font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                      transition-all duration-300 shadow-lg hover:shadow-xl">
                Coba Deteksi Sekarang
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    /* === Stat Card Count-Up Animation === */
    document.addEventListener('DOMContentLoaded', function () {
        const statNumbers = document.querySelectorAll('.stat-number');

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target'), 10);
                    animateCount(el, target);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(function (el) {
            observer.observe(el);
        });

        function animateCount(el, target) {
            const duration = 1500;
            const start = 0;
            const startTime = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(start + (target - start) * eased);

                el.textContent = current.toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.textContent = target.toLocaleString('id-ID');
                }
            }

            requestAnimationFrame(update);
        }
    });

    /* === Scroll Reveal Animation === */
    document.addEventListener('DOMContentLoaded', function () {
        const revealElements = document.querySelectorAll('section > div');

        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        revealElements.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            revealObserver.observe(el);
        });
    });
</script>
<style>
    .revealed {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
</style>
@endpush
