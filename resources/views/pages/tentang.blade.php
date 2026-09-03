@extends('layouts.app')

@section('title', 'Tentang Project')
@section('meta_description', 'Tentang SIMAKSI — latar belakang, metodologi, dan sumber data sistem deteksi satwa liar Sumatra berbasis AI.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-forest-900 pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-4">
                Tentang SIMAKSI
            </h1>
            <p class="text-cream-100/70 text-lg max-w-2xl mx-auto">
                Memahami latar belakang, metodologi, dan tujuan di balik sistem
                deteksi dan analisis konflik satwa liar Sumatra.
            </p>
        </div>
    </section>

    {{-- Latar Belakang --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Latar Belakang Masalah"
                align="left"
            />
            <div class="space-y-4 text-text-500 leading-relaxed">
                <p>
                    Sumatra merupakan salah satu pulau dengan keanekaragaman hayati tertinggi di dunia,
                    namun juga menghadapi tekanan ekologis yang sangat besar. Laju deforestasi yang tinggi,
                    terutama untuk perkebunan kelapa sawit dan ekspansi pertanian, menyebabkan fragmentasi
                    habitat yang parah bagi satwa liar.
                </p>
                <p>
                    Kondisi ini memicu peningkatan konflik manusia-satwa (Human-Wildlife Conflict/HWC)
                    yang merugikan kedua belah pihak. Gajah merusak perkebunan, harimau memangsa ternak,
                    dan orangutan kehilangan rumahnya. Data menunjukkan bahwa konflik ini terus meningkat
                    seiring menyempitnya habitat alami.
                </p>
                <p>
                    SIMAKSI hadir sebagai solusi berbasis teknologi untuk membantu memahami dan
                    menganalisis pola konflik ini. Dengan memanfaatkan kecerdasan buatan dan data
                    spasial, sistem ini bertujuan memberikan wawasan yang dapat ditindaklanjuti oleh
                    para pemangku kepentingan konservasi.
                </p>
            </div>
        </div>
    </section>

    {{-- Metodologi --}}
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Metodologi"
                subtitle="Pendekatan teknis yang digunakan dalam sistem ini, dijelaskan dalam bahasa sederhana."
                align="left"
            />

            <div class="space-y-6">
                @php
                    $methods = [
                        [
                            'title' => 'Deteksi Satwa (MegaDetector)',
                            'desc' => 'Langkah pertama adalah mendeteksi apakah ada satwa liar dalam foto camera trap. Kami menggunakan MegaDetector, model AI yang sudah dilatih dengan jutaan gambar camera trap dari seluruh dunia, untuk menemukan posisi hewan dalam foto dan membedakannya dari manusia atau kendaraan.',
                            'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z',
                        ],
                        [
                            'title' => 'Klasifikasi Spesies (ResNet)',
                            'desc' => 'Setelah satwa terdeteksi, model kedua bertugas mengidentifikasi spesies apa yang ada di foto. Kami melatih model ResNet (arsitektur deep learning populer untuk pengenalan gambar) menggunakan dataset foto satwa liar Sumatra dari WCS Camera Traps.',
                            'icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z',
                        ],
                        [
                            'title' => 'Analisis Konflik (Data Spasial)',
                            'desc' => 'Data kejadian konflik manusia-satwa dari berbagai sumber (BKSDA, WWF, taman nasional) dipetakan bersama data biomassa dan tutupan hutan untuk mengidentifikasi pola, zona risiko, dan korelasi antara kehilangan habitat dengan frekuensi konflik.',
                            'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z',
                        ],
                    ];
                @endphp

                @foreach ($methods as $method)
                    <div class="flex gap-5 bg-cream-50 rounded-2xl p-6 border border-cream-100">
                        <div class="w-12 h-12 shrink-0 bg-canopy-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $method['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold font-heading text-forest-900 mb-2">{{ $method['title'] }}</h3>
                            <p class="text-text-500 text-sm leading-relaxed">{{ $method['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Sumber Data --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Sumber Data"
                align="left"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $sources = [
                        ['name' => 'WCS Camera Traps', 'desc' => 'Dataset foto camera trap satwa liar Sumatra dari Wildlife Conservation Society.'],
                        ['name' => 'LILA BC', 'desc' => 'Labeled Information Library of Alexandria: Biology and Conservation. Repositori dataset camera trap terbuka.'],
                        ['name' => 'Global Forest Watch', 'desc' => 'Data tutupan hutan, deforestasi, dan biomassa secara global termasuk wilayah Sumatra.'],
                        ['name' => 'BKSDA & Taman Nasional', 'desc' => 'Data kejadian konflik manusia-satwa dari berbagai instansi konservasi di Sumatra.'],
                    ];
                @endphp

                @foreach ($sources as $source)
                    <div class="bg-white rounded-xl p-5 border border-cream-100 shadow-sm">
                        <h4 class="font-bold text-forest-900 mb-1.5">{{ $source['name'] }}</h4>
                        <p class="text-sm text-text-500">{{ $source['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Info Institusi --}}
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Institusi & Pembimbing"
                align="left"
            />

            <div class="bg-gradient-to-br from-forest-900 to-forest-700 rounded-2xl p-8 lg:p-10 text-cream-50">
                <div class="space-y-4">
                    <p class="text-cream-100/70 leading-relaxed">
                        SIMAKSI dikembangkan sebagai Capstone Project semester 5. Project ini bertujuan
                        mengaplikasikan ilmu yang telah dipelajari selama perkuliahan dalam bentuk solusi
                        nyata untuk isu konservasi satwa liar di Indonesia.
                    </p>
                    <div class="pt-4 border-t border-forest-700/50 text-sm text-cream-100/60">
                        <p>Informasi detail mengenai institusi dan pembimbing akan ditambahkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
