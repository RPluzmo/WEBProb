<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    @endpush

    <div class="map-filters">
        <a class="map-filter {{ $filter === 'all' ? 'is-active' : '' }}" href="{{ route('home') }}">Visas trases</a>
        <a class="map-filter {{ $filter === 'active' ? 'is-active' : '' }}" href="{{ route('active.tracks') }}">Aktīvās trases</a>
    </div>

    <div id="map" class="map-box"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const baseUrl = @json(url('/'));
        const tracks = @json($tracks);

        const bounds = L.latLngBounds([55.6, 20.9], [58.1, 28.3]);
        const map = L.map('map', {
            center: [56.95, 24.1],
            zoom: 8,
            minZoom: 7,
            maxBounds: bounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        tracks.forEach(track => {
            const icon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div class="track-marker">${track.riders_count ?? 0}</div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            const coverPath = track.images && track.images[0] ? track.images[0].path : null;
            const coverHtml = coverPath
                ? `<img class="popup-cover" data-lightbox-src="${baseUrl}/${coverPath}" src="${baseUrl}/${coverPath}" alt="${track.name}">`
                : '';

            L.marker([track.lat, track.lng], { icon })
                .addTo(map)
                .bindPopup(`
                    <div class="track-popup">
                        ${coverHtml}
                        <span class="popup-title">${track.name}</span>
                        Braucēji: <strong>${track.riders_count ?? 0}</strong><br>
                        <a class="popup-link" href="/tracks/${track.id}">Apskatīt</a>
                    </div>
                `);
        });
    </script>
</x-layout>
