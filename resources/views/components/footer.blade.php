{{-- Footer Component (design.md §4.3) --}}
<footer class="bg-forest-900 text-cream-100/80 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            {{-- Kolom 1: Tentang --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo-simaksi.png') }}"
                         alt="SIMAKSI Logo"
                         class="w-10 h-10 rounded-full object-cover">
                    <span class="text-cream-50 font-heading text-xl font-bold tracking-wide">SIMAKSI</span>
                </div>
                <p class="text-sm leading-relaxed">
                    Sistem Deteksi & Analisis Konflik Satwa Liar Sumatra berbasis AI.
                    Capstone Project untuk konservasi satwa liar melalui teknologi.
                </p>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div>
                <h4 class="text-cream-50 font-heading text-lg font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2.5">
                    @php
                        $footerLinks = [
                            ['url' => '/', 'label' => 'Beranda'],
                            ['url' => '/tentang', 'label' => 'Tentang'],
                            ['url' => '/satwa', 'label' => 'Satwa Liar'],
                            ['url' => '/kontak', 'label' => 'Kontak'],
                        ];
                    @endphp
                    @foreach ($footerLinks as $link)
                        <li>
                            <a href="{{ url($link['url']) }}"
                               class="text-sm hover:text-cream-50 hover:translate-x-1 inline-block transition-all duration-300">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Kolom 3: Fitur --}}
            <div>
                <h4 class="text-cream-50 font-heading text-lg font-semibold mb-4">Fitur</h4>
                <ul class="space-y-2.5">
                    @php
                        $featureLinks = [
                            ['url' => '/deteksi', 'label' => 'Deteksi Satwa'],
                            ['url' => '/peta-biomassa', 'label' => 'MapBiomas'],
                            ['url' => '/satwa', 'label' => 'Database Spesies'],
                        ];
                    @endphp
                    @foreach ($featureLinks as $link)
                        <li>
                            <a href="{{ url($link['url']) }}"
                               class="text-sm hover:text-cream-50 hover:translate-x-1 inline-block transition-all duration-300">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Kolom 4: Kontak --}}
            <div>
                <h4 class="text-cream-50 font-heading text-lg font-semibold mb-4">Kontak</h4>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Capstone Project<br>Semester 5</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>simaksi@university.ac.id</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="mt-10 pt-8 border-t border-forest-700/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-cream-100/60">
                    &copy; {{ date('Y') }} SIMAKSI. Capstone Project.
                </p>
                <p class="text-xs text-cream-100/60">
                    AI-Based Wildlife Detection & Conflict Analysis
                </p>
            </div>
        </div>
    </div>
</footer>
