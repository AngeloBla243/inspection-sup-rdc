@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Liste des rapports d'inspection</h1>
            <a href="{{ route('admin.inspection_reports.create') }}" class="btn btn-primary mb-3">Ajouter un rapport</a>

            <form method="GET" action="{{ route('admin.inspection_reports.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="inspector_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Filtrer par inspecteur --</option>
                            @foreach ($inspectors as $inspector)
                                <option value="{{ $inspector->id }}"
                                    {{ request('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                    {{ $inspector->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="university_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Filtrer par université --</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}"
                                    {{ request('university_id') == $university->id ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" value="{{ request('date') }}" class="form-control"
                            onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </section>

        <section class="content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Inspection</th>
                        <th>Inspecteur</th>
                        <th>Date de création</th>
                        <th>Données</th>
                        <th>Position GPS</th>
                        <th>Pièce jointe</th>
                        <th>Signature électronique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report->inspection->university->name ?? '' }}
                                ({{ $report->inspection->date->format('d/m/Y') ?? '' }})
                            </td>
                            <td>{{ $report->inspector->name ?? '' }}</td>
                            <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ Str::limit($report->data, 50) }}</td>
                            <td>{{ $report->gps_position }}</td>
                            <td>
                                @if ($report->attachment)
                                    <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank">Voir</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $report->electronic_signature ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.inspection_reports.show', $report->id) }}"
                                    class="btn btn-info btn-sm">Voir</a>
                                <a href="{{ route('admin.inspection_reports.edit', $report->id) }}"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.inspection_reports.destroy', $report->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $reports->links() }}
        </section>
    </div>
@endsection
