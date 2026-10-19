{{-- Result Card Component (design.md §4.3) --}}
{{-- Props: $nama, $namaIlmiah, $confidence, $status, $slug --}}

@props([
    'nama',
    'namaIlmiah',
    'confidence',
    'status' => null,
    'slug' => null,
])

@php
    // API mengembalikan confidence sebagai 0–1 (misal 0.92).
    // Konversi ke persentase 0–100 untuk tampilan.
    $confidence = $confidence <= 1 ? $confidence * 100 : $confidence;

    // Color berdasarkan confidence level
    if ($confidence >= 90) {
        $confColor = 'text-canopy-500';
        $confBg = 'bg-canopy-500/10';
        $confLabel = 'Tinggi';
    } elseif ($confidence >= 75) {
        $confColor = 'text-earth-400';
        $confBg = 'bg-earth-400/10';
        $confLabel = 'Sedang';
    } else {
        $confColor = 'text-alert-500';
        $confBg = 'bg-alert-500/10';
        $confLabel = 'Rendah';
    }

    $statusColors = [
        'Kritis' => 'bg-status-kritis text-white',
        'Terancam Punah' => 'bg-status-terancam text-white',
        'Rentan' => 'bg-status-rentan text-white',
        'Hampir Terancam' => 'bg-status-hampir text-forest-900',
        'Risiko Rendah' => 'bg-status-rendah text-white',
        'Data Kurang' => 'bg-status-kurang text-white',
    ];
    $badgeClass = $statusColors[$status] ?? '';
@endphp

<div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-cream-100">

    {{-- Nama spesies --}}
    <div class="mb-5">
        @if ($status)
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClass }} mb-3">
                {{ $status }}
            </span>
        @endif
        <h3 class="text-2xl lg:text-3xl font-bold font-heading text-forest-900">{{ $nama }}</h3>
        <p class="text-canopy-500 italic font-medium mt-1">{{ $namaIlmiah }}</p>
    </div>

    {{-- Confidence score --}}
    <div class="mb-5">
        <p class="text-xs text-text-500 uppercase tracking-wider font-semibold mb-2">Tingkat Kepercayaan</p>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <div class="h-3 bg-cream-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $confBg }}"
                         style="width: 0%; background-color: var(--color-{{ $confidence >= 90 ? 'canopy-500' : ($confidence >= 75 ? 'earth-400' : 'alert-500') }});"
                         id="confidence-bar" data-width="{{ $confidence }}">
                    </div>
                </div>
            </div>
            <div class="text-right shrink-0">
                <span class="text-2xl font-bold font-heading {{ $confColor }}">{{ number_format($confidence, 1) }}%</span>
                <p class="text-xs {{ $confColor }} font-medium">{{ $confLabel }}</p>
            </div>
        </div>
    </div>

    {{-- Link ke detail spesies --}}
    @if ($slug)
        <a href="{{ url('/satwa/' . $slug) }}"
           class="inline-flex items-center gap-2 text-canopy-500 font-semibold text-sm
                  hover:gap-3 transition-all duration-300">
            Lihat informasi lengkap spesies
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var bar = document.getElementById('confidence-bar');
    if (bar) {
        setTimeout(function () {
            bar.style.width = bar.getAttribute('data-width') + '%';
        }, 300);
    }
});
</script>
