{{-- Section Heading Component (design.md §4.3) --}}
{{-- Props: $title (required), $subtitle (optional), $align (optional: 'left'|'center', default 'center') --}}

@props([
    'title',
    'subtitle' => null,
    'align' => 'center',
])

@php
    $alignClass = $align === 'left' ? 'text-left' : 'text-center';
    $lineClass = $align === 'left' ? 'mr-auto' : 'mx-auto';
@endphp

<div class="{{ $alignClass }} mb-8 lg:mb-12">
    {{-- Garis aksen kecil di atas (khas gaya wildnet.org) --}}
    <div class="w-12 h-1 bg-canopy-500 rounded-full {{ $lineClass }} mb-4"></div>

    <h2 class="text-3xl lg:text-4xl font-bold font-heading text-forest-900">
        {{ $title }}
    </h2>

    @if ($subtitle)
        <p class="mt-3 text-base lg:text-lg text-text-500 max-w-2xl {{ $align === 'center' ? 'mx-auto' : '' }}">
            {{ $subtitle }}
        </p>
    @endif
</div>
