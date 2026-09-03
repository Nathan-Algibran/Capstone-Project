{{-- Map Container Component (design.md §4.3) --}}
{{-- Reusable Leaflet.js map. Dipakai di halaman hasil deteksi dan peta eksplorasi. --}}
{{-- Props:
    $mapId       (string, default 'map') — ID unik element
    $center      (array ['lat' => ..., 'lng' => ...]) — koordinat pusat
    $zoom        (int, default 7) — zoom level
    $height      (string, default '500px') — tinggi map
    $markers     (array of ['lat', 'lng', 'nama', 'tanggal', 'sumber', 'deskripsi']) — data marker konflik
    $habitatLabel (string, optional) — label area habitat
--}}

@props([
    'mapId' => 'map',
    'center' => ['lat' => -0.5, 'lng' => 101.5],
    'zoom' => 7,
    'height' => '500px',
    'markers' => [],
    'habitatLabel' => null,
])

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="rounded-2xl overflow-hidden shadow-sm border border-cream-100 bg-white">
    {{-- Map header --}}
    @if ($habitatLabel)
        <div class="px-5 py-3 bg-forest-900 flex items-center gap-3">
            <svg class="w-5 h-5 text-canopy-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
            </svg>
            <span class="text-cream-50 text-sm font-medium">{{ $habitatLabel }}</span>
        </div>
    @endif

    {{-- Map container --}}
    <div id="{{ $mapId }}" style="height: {{ $height }}; width: 100%;"></div>

    {{-- Legend --}}
    <div class="px-5 py-3 bg-cream-50 border-t border-cream-100 flex flex-wrap items-center gap-4 text-xs text-text-500">
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 bg-alert-500 rounded-full inline-block"></span>
            <span>Titik Konflik</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 bg-canopy-500 rounded-full inline-block"></span>
            <span>Area Habitat</span>
        </div>
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('{{ $mapId }}').setView([{{ $center['lat'] }}, {{ $center['lng'] }}], {{ $zoom }});

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
    }).addTo(map);

    // Custom icon untuk marker konflik
    var conflictIcon = L.divIcon({
        html: '<div style="background:#C1502E;width:12px;height:12px;border-radius:50%;border:2px solid #fff;box-shadow:0 1px 4px rgba(0,0,0,0.3);"></div>',
        className: '',
        iconSize: [12, 12],
        iconAnchor: [6, 6],
    });

    // Markers
    var markers = @json($markers);
    var markerGroup = [];

    markers.forEach(function (m) {
        var popupContent = '<div style="font-family:Inter,sans-serif;min-width:180px;">' +
            '<p style="font-weight:600;font-size:14px;margin:0 0 4px;color:#1B3A2B;">' + m.nama + '</p>' +
            '<p style="font-size:12px;color:#5C6660;margin:0 0 6px;">' + m.tanggal + '</p>' +
            '<p style="font-size:12px;color:#5C6660;margin:0 0 4px;">' + (m.deskripsi || '') + '</p>' +
            '<p style="font-size:11px;color:#B08B5A;margin:0;">Sumber: ' + (m.sumber || 'Tidak diketahui') + '</p>' +
            '</div>';

        var marker = L.marker([m.lat, m.lng], { icon: conflictIcon })
            .bindPopup(popupContent)
            .addTo(map);

        markerGroup.push(marker);
    });

    // Fit bounds jika ada marker
    if (markerGroup.length > 0) {
        var group = L.featureGroup(markerGroup);
        map.fitBounds(group.getBounds().pad(0.3));
    }
});
</script>
