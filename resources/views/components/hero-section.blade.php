{{-- Hero Section Component (design.md §4.3 + §5.1) --}}
{{-- Props: $title, $subtitle, $bgImage (optional), $showCta (default true) --}}

@props([
    'title' => 'Melindungi Satwa Liar Sumatra dengan Kecerdasan Buatan',
    'subtitle' => 'Sistem deteksi dan analisis konflik satwa liar berbasis AI untuk mendukung upaya konservasi di Pulau Sumatra.',
    'bgImage' => asset('images/hero.png'),
    'showCta' => true,
])

<section class="relative min-h-[85vh] lg:min-h-[90vh] flex items-center overflow-hidden" id="hero-section">

    {{-- Background with Ken Burns animation (like wildnet.org) --}}
    <div class="absolute inset-0 z-0 overflow-hidden">
        @if ($bgImage)
            <img src="{{ $bgImage }}" alt=""
                 class="w-full h-full object-cover hero-ken-burns"
                 loading="eager">
        @else
            <div class="w-full h-full bg-gradient-to-br from-forest-900 via-forest-700 to-canopy-500 hero-ken-burns"></div>
        @endif

        {{-- Overlay gelap --}}
        <div class="absolute inset-0 bg-forest-900/55"></div>

        {{-- Gradient overlay for text readability --}}
        <div class="absolute inset-0 bg-gradient-to-t from-forest-900/80 via-forest-900/20 to-forest-900/40"></div>
    </div>

    {{-- Decorative floating orbs --}}
    <div class="absolute top-20 right-10 w-72 h-72 bg-canopy-500/8 rounded-full blur-3xl hero-orb-drift"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-earth-400/8 rounded-full blur-3xl hero-orb-drift" style="animation-delay: -5s;"></div>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 w-full">
        <div class="max-w-3xl">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-cream-50/10 backdrop-blur-sm rounded-full
                        border border-cream-50/20 mb-6 animate-fade-in">
                <span class="w-2 h-2 bg-canopy-500 rounded-full animate-pulse"></span>
                <span class="text-cream-50/90 text-sm font-medium">AI-Based Wildlife Detection System</span>
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold font-heading text-cream-50
                       leading-tight tracking-tight animate-slide-up">
                {{ $title }}
            </h1>

            {{-- Subheadline --}}
            <p class="mt-6 text-lg lg:text-xl text-cream-100/80 leading-relaxed max-w-2xl animate-slide-up"
               style="animation-delay: 0.15s;">
                {{ $subtitle }}
            </p>

            {{-- CTA Buttons --}}
            @if ($showCta)
                <div class="mt-8 lg:mt-10 flex flex-col sm:flex-row gap-4 animate-slide-up"
                     style="animation-delay: 0.3s;">
                    <a href="{{ url('/deteksi') }}"
                       class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-canopy-500 text-cream-50
                              font-semibold rounded-xl hover:bg-forest-700 active:scale-95
                              transition-all duration-300 shadow-lg hover:shadow-xl text-base">
                        <span>Coba Deteksi Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#tentang-fitur"
                       class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-cream-50/10
                              backdrop-blur-sm text-cream-50 font-semibold rounded-xl border border-cream-50/25
                              hover:bg-cream-50/20 active:scale-95 transition-all duration-300 text-base">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
        <div class="w-6 h-10 border-2 border-cream-50/40 rounded-full flex items-start justify-center p-1.5">
            <div class="w-1.5 h-3 bg-cream-50/60 rounded-full animate-scroll-down"></div>
        </div>
    </div>
</section>

{{-- Hero animations --}}
<style>
    /* Ken Burns slow zoom + pan (like wildnet.org video) */
    @keyframes ken-burns {
        0%   { transform: scale(1.0) translate(0, 0); }
        50%  { transform: scale(1.15) translate(-1.5%, -1%); }
        100% { transform: scale(1.0) translate(0, 0); }
    }
    .hero-ken-burns {
        animation: ken-burns 25s ease-in-out infinite;
        will-change: transform;
    }

    /* Floating orb drift */
    @keyframes orb-drift {
        0%   { transform: translate(0, 0) scale(1); }
        33%  { transform: translate(15px, -20px) scale(1.05); }
        66%  { transform: translate(-10px, 10px) scale(0.95); }
        100% { transform: translate(0, 0) scale(1); }
    }
    .hero-orb-drift {
        animation: orb-drift 12s ease-in-out infinite;
    }

    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scroll-down {
        0%, 100% { opacity: 0; transform: translateY(0); }
        50% { opacity: 1; transform: translateY(6px); }
    }
    .animate-fade-in {
        animation: fade-in 0.6s ease-out both;
    }
    .animate-slide-up {
        animation: slide-up 0.7s ease-out both;
    }
    .animate-scroll-down {
        animation: scroll-down 2s ease-in-out infinite;
    }

    /* Respect reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .hero-ken-burns, .hero-orb-drift {
            animation: none;
        }
    }
</style>
