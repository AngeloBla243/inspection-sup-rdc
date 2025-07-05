@extends('layouts.app')

@section('style')
    <!-- Font Awesome for icons -->
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
                        <h1 class="h3 mb-0">Liste des Inspecteurs</h1>
                    </div>
                    <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.inspecteur.add') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Ajouter un nouvel Inspecteur
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0"><i class="fas fa-user-tie"></i> Inspecteurs</h3>
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
                                        <th>Dernière position</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inspecteurs as $inspecteur)
                                        <tr>
                                            <td>{{ $inspecteur->id }}</td>
                                            <td>
                                                <img src="{{ $inspecteur->profile_picture ? asset('storage/' . $inspecteur->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($inspecteur->name) }}"
                                                    class="rounded-circle border"
                                                    style="width: 48px; height: 48px; object-fit: cover;">
                                            </td>
                                            <td>{{ $inspecteur->name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $inspecteur->status === 'actif' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($inspecteur->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $inspecteur->email }}</td>
                                            <td>{{ $inspecteur->created_at ? $inspecteur->created_at->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($inspecteur->last_login_latitude && $inspecteur->last_login_longitude)
                                                    <button class="btn btn-info btn-sm view-map"
                                                        data-lat="{{ $inspecteur->last_login_latitude }}"
                                                        data-lng="{{ $inspecteur->last_login_longitude }}"
                                                        data-name="{{ $inspecteur->name }}">
                                                        <i class="fas fa-map-marked-alt"></i> Voir carte
                                                    </button>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.inspecteur.edit', $inspecteur->id) }}"
                                                    class="btn btn-primary btn-sm me-1" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.inspecteur.delete', $inspecteur->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet inspecteur ?');"
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
                                        <h5 class="modal-title"><i class="fas fa-map-marked-alt"></i> Dernière position de
                                            connexion</h5>
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
                        {{ $inspecteurs->links() }}
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
                const lat = $(this).data('lat'); // last_login_latitude
                const lng = $(this).data('lng'); // last_login_longitude
                const name = $(this).data('name');
                $('#mapModal').modal('show');

                setTimeout(function() {
                    if (map) {
                        map.remove();
                    }
                    map = L.map('map').setView([lat, lng], 13);

                    // OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([lat, lng], {
                            icon: L.icon({
                                iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                                iconSize: [38, 38],
                                iconAnchor: [19, 38],
                                popupAnchor: [0, -38]
                            })
                        }).addTo(map)
                        .bindPopup('<b>' + name + '</b><br/>Dernière connexion ici')
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
