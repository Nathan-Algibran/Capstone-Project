{{-- Species Card Component (design.md §4.3 + §5.1) --}}
{{-- Props: $nama (required), $namaIlmiah (required), $status (required), $foto (optional), $slug (optional) --}}

@props([
    'nama',
    'namaIlmiah',
    'status',
    'foto' => null,
    'slug' => null,
])

@php
    $statusColors = [
        'Kritis' => 'bg-status-kritis text-white',
        'Terancam Punah' => 'bg-status-terancam text-white',
        'Rentan' => 'bg-status-rentan text-white',
        'Hampir Terancam' => 'bg-status-hampir text-forest-900',
        'Risiko Rendah' => 'bg-status-rendah text-white',
        'Data Kurang' => 'bg-status-kurang text-white',
    ];
    $badgeClass = $statusColors[$status] ?? 'bg-text-500/50 text-cream-50';
    $href = $slug ? url('/satwa/' . $slug) : '#';
@endphp

<a href="{{ $href }}"
   class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg
          border border-cream-100 transition-all duration-300 hover:-translate-y-1.5">

    {{-- Foto --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-cream-100">
        @if ($foto)
            <img src="{{ $foto }}" alt="{{ $nama }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                 loading="lazy">
        @else
            {{-- Placeholder --}}
            <div class="w-full h-full bg-gradient-to-br from-forest-700 to-canopy-500 flex items-center justify-center">
                <svg class="w-16 h-16 text-cream-50/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                </svg>
            </div>
        @endif

        {{-- Badge status konservasi --}}
        <div class="absolute top-3 right-3">
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}
                         shadow-sm backdrop-blur-sm">
                {{ $status }}
            </span>
        </div>

        {{-- Hover overlay --}}
        <div class="absolute inset-0 bg-forest-900/0 group-hover:bg-forest-900/20 transition-all duration-300
                    flex items-center justify-center">
            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform
                        translate-y-4 group-hover:translate-y-0">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-cream-50/90 text-forest-900
                             text-sm font-semibold rounded-lg shadow-lg">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-4 lg:p-5">
        <h3 class="text-lg font-bold font-heading text-forest-900 group-hover:text-canopy-500
                   transition-colors duration-300">
            {{ $nama }}
        </h3>
        <p class="mt-1 text-sm text-text-500 italic">{{ $namaIlmiah }}</p>
    </div>
</a>
