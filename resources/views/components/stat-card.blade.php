{{-- Stat Card Component (design.md §4.3 + §5.1) --}}
{{-- Props: $value (required), $label (required), $suffix (optional, e.g. '%', '+') --}}

@props([
    'value',
    'label',
    'suffix' => '',
])

<div class="group relative bg-white rounded-2xl p-6 lg:p-8 shadow-sm hover:shadow-md
            border border-cream-100 transition-all duration-300 hover:-translate-y-1">

    {{-- Aksen garis atas --}}
    <div class="absolute top-0 left-6 right-6 h-1 bg-gradient-to-r from-canopy-500 to-earth-400
                rounded-b-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

    {{-- Angka besar --}}
    <div class="flex items-baseline gap-1">
        <span class="text-4xl lg:text-5xl font-bold font-heading text-forest-900 stat-number"
              data-target="{{ $value }}">
            0
        </span>
        @if ($suffix)
            <span class="text-2xl lg:text-3xl font-bold font-heading text-canopy-500">{{ $suffix }}</span>
        @endif
    </div>

    {{-- Label --}}
    <p class="mt-2 text-sm lg:text-base text-text-500 font-medium">{{ $label }}</p>
</div>
