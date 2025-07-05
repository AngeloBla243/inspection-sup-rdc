@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Inspections planifiées</h1>

                {{-- Barre de recherche/filtre --}}
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <form method="GET" class="form-inline row">
                            <div class="form-group col-md-4 mb-2">
                                <label for="date" class="mr-2">Date :</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="status" class="mr-2">Statut :</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Tous statuts</option>
                                    <option value="à venir" {{ request('status') == 'à venir' ? 'selected' : '' }}>À venir
                                    </option>
                                    <option value="en cours" {{ request('status') == 'en cours' ? 'selected' : '' }}>En
                                        cours</option>
                                    <option value="terminée" {{ request('status') == 'terminée' ? 'selected' : '' }}>
                                        Terminée</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Filtrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tableau stylisé --}}
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title text-white">Liste des inspections</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Université</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inspections as $insp)
                                    <tr>
                                        <td>
                                            <i class="fas fa-university text-info"></i>
                                            {{ $insp->university->name }}
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $insp->date->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            @if ($insp->status == 'à venir')
                                                <span class="badge badge-info">À venir</span>
                                            @elseif($insp->status == 'en cours')
                                                <span class="badge badge-warning text-white">En cours</span>
                                            @elseif($insp->status == 'terminée')
                                                <span class="badge badge-success">Terminée</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($insp->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($insp->status == 'à venir' || $insp->status == 'en cours')
                                                <a href="{{ route('inspecteur.inspections.form', $insp->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play"></i> Commencer
                                                </a>
                                            @else
                                                <a href="{{ route('inspecteur.inspections.form', $insp->id) }}"
                                                    class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-eye"></i> Voir détails
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucune inspection planifiée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($inspections->hasPages())
                        <div class="card-footer">
                            {{ $inspections->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
