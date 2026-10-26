{{-- Navbar Component (design.md §4.3) --}}
<nav class="bg-forest-900 sticky top-0 z-50 shadow-lg" id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo-simaksi.png') }}"
                     alt="SIMAKSI Logo"
                     class="w-10 h-10 lg:w-12 lg:h-12 rounded-full object-cover
                            transition-transform duration-300 group-hover:scale-110">
                <span class="text-cream-50 font-heading text-xl lg:text-2xl font-bold tracking-wide">SIMAKSI</span>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center gap-1">
                @php
                    $menuItems = [
                        ['url' => '/', 'label' => 'Beranda', 'pattern' => '/'],
                        ['url' => '/tentang', 'label' => 'Tentang', 'pattern' => 'tentang*'],
                        ['url' => '/satwa', 'label' => 'Satwa Liar', 'pattern' => 'satwa*'],
                        ['url' => '/deteksi', 'label' => 'Deteksi', 'pattern' => 'deteksi*'],
                        ['url' => '/peta-biomassa', 'label' => 'MapBiomas', 'pattern' => 'peta-biomassa*'],
                        ['url' => '/kontak', 'label' => 'Kontak', 'pattern' => 'kontak*'],
                    ];
                @endphp

                @foreach ($menuItems as $item)
                    <a href="{{ url($item['url']) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300
                              {{ request()->is($item['pattern']) 
                                 ? 'text-cream-50 bg-forest-700' 
                                 : 'text-cream-100/80 hover:text-cream-50 hover:bg-forest-700/50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                {{-- CTA Button --}}
                <a href="{{ url('/deteksi') }}"
                   class="ml-4 px-5 py-2.5 bg-canopy-500 text-cream-50 text-sm font-semibold rounded-lg
                          hover:bg-forest-700 active:scale-95 transition-all duration-300 shadow-md hover:shadow-lg">
                    Coba Deteksi
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button type="button" id="mobile-menu-btn"
                    class="lg:hidden p-2 rounded-lg text-cream-100/80 hover:text-cream-50 hover:bg-forest-700/50
                           transition-all duration-300"
                    aria-label="Toggle menu"
                    aria-expanded="false">
                <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Panel --}}
    <div id="mobile-menu" class="lg:hidden overflow-hidden transition-all duration-300 ease-in-out"
         style="max-height: 0; opacity: 0;">
        <div class="px-4 pb-4 space-y-1 border-t border-forest-700/50">
            @foreach ($menuItems as $item)
                <a href="{{ url($item['url']) }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300
                          {{ request()->is($item['pattern']) 
                             ? 'text-cream-50 bg-forest-700' 
                             : 'text-cream-100/80 hover:text-cream-50 hover:bg-forest-700/50' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ url('/deteksi') }}"
               class="block mt-2 px-4 py-3 bg-canopy-500 text-cream-50 text-sm font-semibold rounded-lg
                      text-center hover:bg-forest-700 active:scale-95 transition-all duration-300">
                Coba Deteksi
            </a>
        </div>
    </div>
</nav>

{{-- Mobile menu toggle script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');
    let isOpen = false;

    btn.addEventListener('click', function () {
        isOpen = !isOpen;
        btn.setAttribute('aria-expanded', isOpen);

        if (isOpen) {
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.style.opacity = '1';
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
        } else {
            menu.style.maxHeight = '0';
            menu.style.opacity = '0';
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    });
});
</script>
