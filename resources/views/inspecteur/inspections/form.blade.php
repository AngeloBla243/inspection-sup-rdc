@extends('layouts.app')

@section('style')
    <style>
        .inspection-section {
            background: #fff;
            border-radius: 8px;
            padding: 2rem 2.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 2rem;
        }

        .inspection-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .prof-list .list-group-item {
            background: #f8f9fa;
            border: none;
            border-bottom: 1px solid #e9ecef;
        }

        .prof-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 1rem;
        }

        .form-control-file {
            margin-top: 0.5rem;
        }

        .btn-success {
            font-size: 1.15em;
            padding: 0.75em 2em;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container py-4">
            <div class="inspection-section mx-auto" style="max-width: 900px;">
                <div class="inspection-title">
                    <i class="fas fa-clipboard-check"></i>
                    Inspection : {{ $inspection->university->name }}
                </div>

                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('inspecteur.inspections.update', $inspection->id) }}">
                    @csrf

                    {{-- Adresse université --}}
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" class="form-control" value="{{ $inspection->university->location }}" readonly>
                    </div>

                    {{-- Liste des professeurs --}}
                    <div class="form-group">
                        <label><i class="fas fa-users"></i> Professeurs recensés</label>
                        <ul class="list-group prof-list">
                            @foreach ($inspection->university->professors as $prof)
                                <li class="list-group-item d-flex align-items-center">
                                    @if ($prof->photo)
                                        <img src="{{ asset('storage/' . $prof->photo) }}" alt="Photo" class="prof-photo">
                                    @else
                                        <span class="prof-photo" style="background: #e9ecef;"></span>
                                    @endif
                                    <div>
                                        <strong>{{ $prof->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($prof->status) }}</small>
                                    </div>
                                    <div class="ml-auto">
                                        <label class="mb-0">Scan(s)/Photo(s) :</label>
                                        <input type="file" name="prof_documents[{{ $prof->id }}][]" accept="image/*"
                                            capture="environment" multiple class="form-control-file">
                                        <small class="form-text text-muted">
                                            Prends une photo du document ou sélectionne un fichier.
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Scan(s) pour l’université --}}
                    <div class="form-group mt-3">
                        <label><i class="fas fa-file-alt"></i> Scan(s)/Photo(s) pour l’université :</label>
                        <input type="file" name="univ_documents[]" accept="image/*" capture="environment" multiple
                            class="form-control-file">
                        <small class="form-text text-muted">
                            Prends une photo du document administratif ou sélectionne un fichier.
                        </small>
                    </div>

                    {{-- Photos générales --}}
                    <div class="form-group">
                        <label><i class="fas fa-camera"></i> Photos (façade, bureaux, salles...)</label>
                        <input type="file" name="attachments[]" accept="image/*" capture="environment" multiple
                            class="form-control-file">
                        <small class="form-text text-muted">
                            Prends une photo directement ou sélectionne une image.
                        </small>
                    </div>

                    {{-- Signature électronique --}}
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Signature électronique</label>
                        <input type="text" name="signature" class="form-control" value="{{ old('signature') }}" required>
                    </div>

                    {{-- Coordonnées GPS (cachées) --}}
                    <input type="hidden" name="gps_latitude" id="gps_latitude">
                    <input type="hidden" name="gps_longitude" id="gps_longitude">

                    <button type="submit" class="btn btn-success btn-block mt-4">
                        <i class="fas fa-check-circle"></i> Valider l’inspection
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- FontAwesome pour les icônes (si pas déjà inclus dans ton layout) -->
    <script src="https://kit.fontawesome.com/3b4d9c6b2c.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    $('#gps_latitude').val(pos.coords.latitude);
                    $('#gps_longitude').val(pos.coords.longitude);
                });
            }
        });
    </script>
@endsection
