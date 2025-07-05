@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Tableau de bord Inspecteur</h1>

                {{-- Résumé général --}}
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $universitesInspectees ?? 0 }}</h3>
                                <p>Universités inspectées</p>
                            </div>
                            <div class="icon"><i class="fas fa-university"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $professeursEnregistres ?? 0 }}</h3>
                                <p>Professeurs enregistrés</p>
                            </div>
                            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>
                                    @if (isset($dernierePosition['lat']) && isset($dernierePosition['lng']))
                                        <small>{{ $dernierePosition['lat'] }}, {{ $dernierePosition['lng'] }}</small>
                                    @else
                                        <small>Non disponible</small>
                                    @endif
                                </h3>
                                <p>Dernière géolocalisation</p>
                            </div>
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                        </div>
                    </div>
                </div>

                {{-- Prochaines inspections --}}
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">Prochaines inspections planifiées</h3>
                    </div>
                    <div class="card-body table-responsive p-0" style="max-height: 250px;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Université</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prochainesInspections as $insp)
                                    <tr>
                                        <td>{{ $insp->university->name }}</td>
                                        <td>{{ $insp->date->format('d/m/Y') }}</td>
                                        <td>
                                            <span
                                                class="badge
                                            @if ($insp->status == 'à venir') badge-info
                                            @elseif($insp->status == 'en cours') badge-warning
                                            @else badge-secondary @endif">
                                                {{ ucfirst($insp->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Aucune inspection à venir.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Raccourcis --}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        <a href="{{ route('inspecteur.inspections.index') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-calendar-check"></i> Voir mes inspections
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('inspecteur.professeurs.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-user-plus"></i> Ajouter un professeur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
