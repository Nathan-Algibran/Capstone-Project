@extends('layouts.app')

@section('title', 'Deteksi Satwa')
@section('meta_description', 'Upload foto camera trap untuk mendeteksi dan mengklasifikasikan spesies satwa liar Sumatra secara otomatis menggunakan AI.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-forest-900 pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-4">
                Deteksi Satwa Liar
            </h1>
            <p class="text-cream-100/70 text-lg max-w-2xl mx-auto">
                Upload foto camera trap Anda dan sistem AI akan mengidentifikasi
                spesies satwa liar secara otomatis.
            </p>
        </div>
    </section>

    {{-- Upload Section --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-upload-dropzone />
        </div>
    </section>

    {{-- Bagaimana Cara Kerjanya --}}
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading
                title="Bagaimana Cara Kerjanya?"
                subtitle="Tiga langkah sederhana untuk menganalisis foto camera trap Anda."
            />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                @php
                    $steps = [
                        [
                            'step' => '01',
                            'title' => 'Upload Foto',
                            'desc' => 'Unggah foto camera trap dalam format JPG atau PNG. Sistem menerima foto dari berbagai jenis kamera.',
                            'icon' => 'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5',
                        ],
                        [
                            'step' => '02',
                            'title' => 'Deteksi & Klasifikasi',
                            'desc' => 'Model AI (MegaDetector + ResNet) mendeteksi keberadaan satwa dan mengklasifikasikan spesiesnya secara otomatis.',
                            'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5',
                        ],
                        [
                            'step' => '03',
                            'title' => 'Analisis Hasil',
                            'desc' => 'Lihat spesies yang terdeteksi, tingkat kepercayaan, peta habitat, dan data interaksi negatif satwa liar.',
                            'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                        ],
                    ];
                @endphp

                @foreach ($steps as $step)
                    <div class="group relative bg-cream-50 rounded-2xl p-6 lg:p-8 border border-cream-100
                                hover:border-canopy-500/30 hover:shadow-md transition-all duration-300">
                        {{-- Step number --}}
                        <span class="text-5xl font-bold font-heading text-canopy-500/15 absolute top-4 right-5">
                            {{ $step['step'] }}
                        </span>

                        <div class="w-12 h-12 bg-canopy-500/10 rounded-xl flex items-center justify-center mb-4
                                    group-hover:bg-canopy-500/20 transition-colors duration-300">
                            <svg class="w-6 h-6 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold font-heading text-forest-900 mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-text-500 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
