@extends('layouts.app')

@section('style')
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
        }

        .leaflet-container {
            font-family: 'Roboto', Arial, sans-serif;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper py-4">
        <section class="content-header mb-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <h1 class="h3 mb-0">Liste des Administrateurs</h1>
                    </div>
                    <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.admin.add') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Ajouter un nouvel Admin
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0"><i class="fas fa-users-cog"></i> Admins</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Créé le</th>
                                        <th>Localisation</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>
                                                <img src="{{ $admin->profile_picture_url }}" class="rounded-circle border"
                                                    style="width: 48px; height: 48px; object-fit: cover;">
                                            </td>
                                            <td>{{ $admin->name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $admin->status === 'actif' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($admin->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($admin->last_login_latitude)
                                                    <button class="btn btn-info btn-sm view-map"
                                                        data-lat="{{ $admin->last_login_latitude }}"
                                                        data-lng="{{ $admin->last_login_longitude }}">
                                                        <i class="fas fa-map-marked-alt"></i> Voir carte
                                                    </button>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.admin.edit', $admin->id) }}"
                                                    class="btn btn-primary btn-sm me-1" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.admin.delete', $admin->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal pour la carte -->
                        <div class="modal fade" id="mapModal" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title"><i class="fas fa-map-marked-alt"></i> Localisation de la
                                            dernière connexion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map = null;
        let marker = null;

        $(document).ready(function() {
            $('.view-map').click(function() {
                const lat = $(this).data('lat');
                const lng = $(this).data('lng');
                $('#mapModal').modal('show');

                setTimeout(function() {
                    if (map) {
                        map.remove();
                    }
                    map = L.map('map').setView([lat, lng], 13);

                    // Fond de carte clair et moderne (CartoDB Positron)
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; <a href="https://carto.com/">CARTO</a> contributors'
                    }).addTo(map);

                    marker = L.marker([lat, lng], {
                            icon: L.icon({
                                iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                                iconSize: [38, 38],
                                iconAnchor: [19, 38],
                                popupAnchor: [0, -38]
                            })
                        }).addTo(map)
                        .bindPopup('<b>Dernière connexion ici</b>')
                        .openPopup();
                }, 300);
            });

            $('#mapModal').on('hidden.bs.modal', function() {
                if (map) {
                    map.remove();
                    map = null;
                }
            });
        });
    </script>
@endsection
