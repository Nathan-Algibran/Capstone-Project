{{-- Map Container Component (design.md §4.3) --}}
{{-- Reusable Leaflet.js map dengan dukungan MapBiomas GEE overlay. --}}
{{-- Dipakai di halaman hasil deteksi dan peta eksplorasi. --}}
{{-- Props:
    $mapId              (string, default 'map') — ID unik element
    $center             (array ['lat' => ..., 'lng' => ...]) — koordinat pusat
    $zoom               (int, default 7) — zoom level
    $height             (string, default '500px') — tinggi map
    $markers            (array of ['lat', 'lng', 'nama', 'tanggal', 'sumber', 'deskripsi']) — data marker konflik
    $habitatLabel       (string, optional) — label area habitat
    $geeData            (array, optional) — {available, tile_url, year, attribution}
    $geeLegend          (array, optional) — legenda kelas MapBiomas
    $clusterCircles     (array, optional) — cluster DBSCAN [{center_lat, center_lng, radius, count}]
--}}

@props([
    'mapId' => 'map',
    'center' => ['lat' => -0.5, 'lng' => 101.5],
    'zoom' => 7,
    'height' => '500px',
    'markers' => [],
    'habitatLabel' => null,
    'geeData' => ['available' => false],
    'geeLegend' => [],
    'clusterCircles' => [],
])

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="rounded-2xl overflow-hidden shadow-sm border border-cream-100 bg-white">
    {{-- Map header --}}
    @if ($habitatLabel)
        <div class="px-5 py-3 bg-forest-900 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-canopy-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <span class="text-cream-50 text-sm font-medium">{{ $habitatLabel }}</span>
            </div>

            {{-- Layer toggle button --}}
            @if ($geeData['available'] ?? false)
                <button type="button"
                        id="{{ $mapId }}-layer-toggle"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold
                               bg-canopy-500/20 text-canopy-300 hover:bg-canopy-500/30
                               transition-all duration-200 cursor-pointer"
                        onclick="window['{{ $mapId }}ToggleLayer'] && window['{{ $mapId }}ToggleLayer']()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L12 12.75 6.429 9.75m11.142 0l4.179 2.25-9.75 5.25-9.75-5.25 4.179-2.25"/>
                    </svg>
                    <span id="{{ $mapId }}-layer-label">MapBiomas: Aktif</span>
                </button>
            @endif
        </div>
    @endif

    {{-- Map container --}}
    <div id="{{ $mapId }}" style="height: {{ $height }}; width: 100%;"></div>

    {{-- Bottom bar: Legend + Controls --}}
    <div class="px-5 py-3 bg-cream-50 border-t border-cream-100">
        {{-- Marker legend --}}
        <div class="flex flex-wrap items-center gap-4 text-xs text-text-500 mb-2">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 bg-alert-500 rounded-full inline-block border border-white shadow-sm"></span>
                <span>Titik Konflik</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 bg-canopy-500 rounded-full inline-block border border-white shadow-sm"></span>
                <span>Area Habitat</span>
            </div>
            @if (count($clusterCircles) > 0)
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-alert-500/30 rounded-full inline-block border border-alert-500"></span>
                    <span>Zona Cluster Konflik</span>
                </div>
            @endif
            @if ($geeData['available'] ?? false)
                <div class="flex items-center gap-1.5 ml-auto">
                    <svg class="w-3 h-3 text-text-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-text-400">MapBiomas {{ $geeData['year'] ?? '' }}</span>
                </div>
            @endif
        </div>

        {{-- MapBiomas land cover legend (collapsible) --}}
        @if ($geeData['available'] ?? false)
            <div id="{{ $mapId }}-legend-panel" class="overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0;">
                <div class="pt-2 border-t border-cream-100">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold text-text-900">Legenda Tutupan Lahan</p>

                        {{-- Opacity slider --}}
                        <div class="flex items-center gap-2">
                            <label for="{{ $mapId }}-opacity" class="text-[10px] text-text-400">Transparansi</label>
                            <input type="range" id="{{ $mapId }}-opacity"
                                   min="0" max="100" value="70" step="5"
                                   class="w-20 h-1 accent-canopy-500 cursor-pointer"
                                   oninput="window['{{ $mapId }}SetOpacity'] && window['{{ $mapId }}SetOpacity'](this.value / 100)">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-1">
                        @foreach ($geeLegend as $item)
                            @if (($item['tipe'] ?? '') !== 'unknown')
                                <div class="flex items-center gap-1.5 py-0.5">
                                    <span class="w-3 h-3 rounded-sm inline-block shrink-0 border border-black/10"
                                          style="background-color: {{ $item['color'] }};"></span>
                                    <span class="text-[10px] text-text-500 leading-tight truncate">{{ $item['label'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Toggle legend button --}}
            <button type="button"
                    id="{{ $mapId }}-legend-toggle"
                    class="mt-1 text-[11px] font-medium text-canopy-500 hover:text-canopy-700
                           transition-colors duration-200 cursor-pointer flex items-center gap-1"
                    onclick="toggleLegend_{{ str_replace('-', '_', $mapId) }}()">
                <svg id="{{ $mapId }}-legend-chevron" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
                <span id="{{ $mapId }}-legend-toggle-text">Tampilkan legenda tutupan lahan</span>
            </button>
        @endif
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('{{ $mapId }}').setView([{{ $center['lat'] }}, {{ $center['lng'] }}], {{ $zoom }});

    // Base tile layer (OpenStreetMap)
    var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
    }).addTo(map);

    // MapBiomas GEE overlay layer
    var mapbiomasLayer = null;
    var mapbiomasVisible = true;

    @if ($geeData['available'] ?? false)
        mapbiomasLayer = L.tileLayer('{!! $geeData['tile_url'] !!}', {
            attribution: '{{ $geeData['attribution'] ?? 'MapBiomas Indonesia' }}',
            maxZoom: 18,
            opacity: 0.7,
        }).addTo(map);

        // Toggle MapBiomas layer
        window['{{ $mapId }}ToggleLayer'] = function () {
            var label = document.getElementById('{{ $mapId }}-layer-label');
            if (mapbiomasVisible) {
                map.removeLayer(mapbiomasLayer);
                mapbiomasVisible = false;
                if (label) label.textContent = 'MapBiomas: Nonaktif';
            } else {
                map.addLayer(mapbiomasLayer);
                mapbiomasVisible = true;
                if (label) label.textContent = 'MapBiomas: Aktif';
            }
        };

        // Set opacity
        window['{{ $mapId }}SetOpacity'] = function (opacity) {
            if (mapbiomasLayer) {
                mapbiomasLayer.setOpacity(opacity);
            }
        };
    @endif

    // Custom icon untuk marker konflik (merah)
    var conflictIcon = L.divIcon({
        html: '<div style="background:#C1502E;width:12px;height:12px;border-radius:50%;border:2px solid #fff;box-shadow:0 2px 6px rgba(193,80,46,0.4);"></div>',
        className: '',
        iconSize: [12, 12],
        iconAnchor: [6, 6],
    });

    // Custom icon untuk marker habitat (hijau)
    var habitatIcon = L.divIcon({
        html: '<div style="background:#4C8C5C;width:12px;height:12px;border-radius:50%;border:2px solid #fff;box-shadow:0 2px 6px rgba(76,140,92,0.4);"></div>',
        className: '',
        iconSize: [12, 12],
        iconAnchor: [6, 6],
    });

    // Markers
    var markers = @json($markers);
    var markerGroup = [];

    markers.forEach(function (m) {
        var popupContent = '<div style="font-family:Inter,sans-serif;min-width:200px;">' +
            '<p style="font-weight:600;font-size:14px;margin:0 0 4px;color:#1B3A2B;">' + m.nama + '</p>' +
            '<p style="font-size:12px;color:#5C6660;margin:0 0 6px;">' + m.tanggal + '</p>' +
            '<p style="font-size:12px;color:#5C6660;margin:0 0 4px;">' + (m.deskripsi || '') + '</p>';

        // Tampilkan kelas lahan jika ada
        if (m.land_class) {
            popupContent += '<p style="font-size:11px;color:#4C8C5C;margin:0 0 4px;">Tutupan: ' + m.land_class + '</p>';
        }

        popupContent += '<p style="font-size:11px;color:#B08B5A;margin:0;">Sumber: ' + (m.sumber || 'Tidak diketahui') + '</p>' +
            '</div>';

        var marker = L.marker([m.lat, m.lng], { icon: conflictIcon })
            .bindPopup(popupContent)
            .addTo(map);

        markerGroup.push(marker);
    });

    // Cluster circles (DBSCAN)
    var clusters = @json($clusterCircles);
    clusters.forEach(function (cl) {
        L.circle([cl.center_lat, cl.center_lng], {
            radius: cl.radius,
            color: '#C1502E',
            weight: 2,
            opacity: 0.6,
            fillColor: '#C1502E',
            fillOpacity: 0.1,
            dashArray: '6, 4',
        }).bindPopup(
            '<div style="font-family:Inter,sans-serif;text-align:center;">' +
            '<p style="font-weight:600;font-size:14px;margin:0 0 4px;color:#C1502E;">Zona Konflik #' + cl.cluster_id + '</p>' +
            '<p style="font-size:12px;color:#5C6660;margin:0;">' + cl.count + ' kejadian dalam radius ' + Math.round(cl.radius / 1000 * 10) / 10 + ' km</p>' +
            '</div>'
        ).addTo(map);
    });

    // Fit bounds jika ada marker
    if (markerGroup.length > 0) {
        var group = L.featureGroup(markerGroup);
        map.fitBounds(group.getBounds().pad(0.3));
    }
});

// Toggle legend panel
@if ($geeData['available'] ?? false)
function toggleLegend_{{ str_replace('-', '_', $mapId) }}() {
    var panel = document.getElementById('{{ $mapId }}-legend-panel');
    var chevron = document.getElementById('{{ $mapId }}-legend-chevron');
    var text = document.getElementById('{{ $mapId }}-legend-toggle-text');

    if (panel.style.maxHeight === '0px' || !panel.style.maxHeight || panel.style.maxHeight === '0') {
        panel.style.maxHeight = panel.scrollHeight + 'px';
        chevron.style.transform = 'rotate(180deg)';
        text.textContent = 'Sembunyikan legenda';
    } else {
        panel.style.maxHeight = '0px';
        chevron.style.transform = 'rotate(0deg)';
        text.textContent = 'Tampilkan legenda tutupan lahan';
    }
}
@endif
</script>
