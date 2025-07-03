@extends('layouts.app') {{-- Assurez-vous que ce layout charge AdminLTE correctement --}}

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Tableau de bord Admin</h1>

                {{-- Résumé général --}}
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalUniversites ?? 0 }}</h3>
                                <p>Universités</p>
                            </div>
                            <div class="icon"><i class="fas fa-university"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalInspecteurs ?? 'Variable non définie' }}</h3>
                                <p>Inspecteurs</p>
                            </div>
                            <div class="icon"><i class="fas fa-user-tie"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalProfesseurs ?? 0 }}</h3>
                                <p>Professeurs</p>
                            </div>
                            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $inspectionsPlanifiees ?? 0 }}</h3>
                                <p>Inspections planifiées</p>
                            </div>
                            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                        </div>
                    </div>
                </div>

                {{-- Graphique --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistiques générales</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statsChart" style="height: 250px;"></canvas>
                    </div>
                </div>

                {{-- Dernières inspections --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dernières inspections réalisées</h3>
                    </div>
                    <div class="card-body table-responsive p-0" style="max-height: 300px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Université</th>
                                    <th>Inspecteur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dernieresInspections ?? [] as $inspection)
                                    <tr>
                                        <td>{{ $inspection['universite'] }}</td>
                                        <td>{{ $inspection['inspecteur'] }}</td>
                                        <td>{{ $inspection['date'] }}</td>
                                        <td>{{ $inspection['statut'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucune inspection récente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Alertes --}}
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Alertes</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            @forelse ($alertes ?? [] as $alerte)
                                <li>{{ $alerte }}</li>
                            @empty
                                <li>Aucune alerte pour le moment.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Chart.js depuis CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Universités', 'Inspecteurs', 'Professeurs', 'Inspections planifiées'],
                    datasets: [{
                        label: 'Nombre',
                        data: [
                            {{ $totalUniversites ?? 0 }},
                            {{ $totalInspecteurs ?? 0 }},
                            {{ $totalProfesseurs ?? 0 }},
                            {{ $inspectionsPlanifiees ?? 0 }}
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
