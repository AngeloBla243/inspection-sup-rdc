@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
        }

        .leaflet-popup-content {
            font-size: 1.05em;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container py-4">
            <h1 class="mb-4"><i class="fas fa-map-marked-alt"></i> Carte des universités & inspecteurs</h1>
            <div id="map"></div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- FontAwesome pour les icônes -->
    <script src="https://kit.fontawesome.com/3b4d9c6b2c.js" crossorigin="anonymous"></script>
    <script>
        const universities = @json($universities);
        const inspectors = @json($inspectors);

        // Centrage initial sur la RDC (adapter si besoin)
        var map = L.map('map').setView([-2.5, 23.7], 6);

        // Fond de carte OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Marqueurs universités
        universities.forEach(function(u) {
            if (u.gps_latitude && u.gps_longitude) {
                L.marker([u.gps_latitude, u.gps_longitude], {
                        icon: L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                            popupAnchor: [0, -32]
                        })
                    })
                    .addTo(map)
                    .bindPopup(
                        `<b><i class="fas fa-university"></i> ${u.name}</b><br>
                    <span class="text-muted">Université</span><br>
                    <small>Lat: ${u.gps_latitude}, Lng: ${u.gps_longitude}</small>`
                    );
            }
        });

        // Marqueurs inspecteurs
        inspectors.forEach(function(i) {
            if (i.last_login_latitude && i.last_login_longitude) {
                L.marker([i.last_login_latitude, i.last_login_longitude], {
                        icon: L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                            popupAnchor: [0, -32]
                        })
                    })
                    .addTo(map)
                    .bindPopup(
                        `<b><i class="fas fa-user-tie"></i> ${i.name}</b><br>
                    <span class="text-muted">Inspecteur</span><br>
                    <small>Email: ${i.email}</small><br>
                    <small>Lat: ${i.last_login_latitude}, Lng: ${i.last_login_longitude}</small>`
                    );
            }
        });
    </script>
@endsection
