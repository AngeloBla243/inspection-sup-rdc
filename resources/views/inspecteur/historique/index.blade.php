@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Historique de mes inspections</h1>

                {{-- Barre de recherche --}}
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <form method="GET" class="form-inline row">
                            <div class="form-group col-md-8 mb-2">
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
                            <div class="form-group col-md-4 mb-2">
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
                        <h3 class="card-title text-white">Mes inspections</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Université</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>GPS</th>
                                    <th>Rapport</th>
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
                                            <span class="badge badge-secondary">
                                                {{ $insp->gps_latitude ?? '-' }}, {{ $insp->gps_longitude ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($insp->latestReport && $insp->latestReport->attachment)
                                                <a href="{{ asset('storage/' . $insp->latestReport->attachment) }}"
                                                    target="_blank">Voir</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucune inspection trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($inspections->hasPages())
                        <div class="card-footer">
                            {{ $inspections->appends(request()->all())->links() }}
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
