@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Liste des Professeurs/Ouvriers</h1>

                {{-- Barre de recherche --}}
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <form method="GET" class="form-inline row">
                            <div class="form-group col-md-3 mb-2">
                                <input type="text" name="matricule" value="{{ request('matricule') }}"
                                    class="form-control" placeholder="Matricule...">
                            </div>
                            <div class="form-group col-md-3 mb-2">
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                    placeholder="Nom...">
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <select name="university" class="form-control select2" style="width: 100%;">
                                    <option value="">Toutes les universités</option>
                                    @foreach ($universities as $univ)
                                        <option value="{{ $univ->id }}"
                                            {{ request('university') == $univ->id ? 'selected' : '' }}>
                                            {{ $univ->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tableau stylisé --}}
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title text-white">Professeurs/Ouvriers</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <a href="{{ route('inspecteur.professeurs.create') }}" class="btn btn-success mb-3">
                            <i class="fas fa-user-plus"></i> Ajouter un professeur/ouvrier
                        </a>
                        <table class="table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th>Universités</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($professors as $prof)
                                    <tr>
                                        <td>{{ $prof->matricule }}</td>
                                        <td>{{ $prof->name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $prof->status == 'ouvrier' ? 'secondary' : 'info' }}">
                                                {{ ucfirst($prof->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @foreach ($prof->universities as $univ)
                                                <span class="badge badge-primary">{{ $univ->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#ficheModal{{ $prof->id }}">
                                                <i class="fas fa-id-card"></i> Fiche
                                            </button>
                                            {{-- Autres boutons de contrôle ici --}}
                                        </td>
                                    </tr>

                                    <!-- Modal pour la fiche du professeur -->
                                    <div class="modal fade" id="ficheModal{{ $prof->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="ficheModalLabel{{ $prof->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ficheModalLabel{{ $prof->id }}">
                                                        Fiche Professeur/Ouvrier
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Fermer">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Matricule :</strong> {{ $prof->matricule }}</p>
                                                    <p><strong>Nom :</strong> {{ $prof->name }}</p>
                                                    <p><strong>Statut :</strong> {{ $prof->status }}</p>
                                                    <p><strong>Universités d'affectation :</strong>
                                                    <ul>
                                                        @foreach ($prof->universities as $univ)
                                                            <li>{{ $univ->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                    </p>
                                                    @if ($prof->photo)
                                                        <p><strong>Photo :</strong><br>
                                                            <img src="{{ asset('storage/' . $prof->photo) }}"
                                                                alt="Photo" class="img-thumbnail" width="120">
                                                        </p>
                                                    @endif
                                                    <p><strong>Date d'ajout :</strong>
                                                        {{ $prof->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucun professeur/ouvrier trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($professors->hasPages())
                        <div class="card-footer">
                            {{ $professors->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Sélectionnez une université",
                allowClear: true
            });
        });
    </script>
@endsection
