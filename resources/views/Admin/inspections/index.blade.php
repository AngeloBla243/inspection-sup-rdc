@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Planification des inspections</h1>
            <a href="{{ route('admin.inspections.create') }}" class="btn btn-primary mb-3">Ajouter une inspection</a>
        </section>

        <section class="content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Université</th>
                        <th>Inspecteur</th>
                        <th>Date</th>
                        <th>Objectif</th>
                        <th>Statut</th>
                        <th>Activée</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inspections as $inspection)
                        <tr>
                            <td>{{ $inspection->university->name }}</td>
                            <td>{{ $inspection->inspector->name }}</td>
                            <td>{{ $inspection->date->format('d/m/Y') }}</td>
                            <td>{{ $inspection->objective }}</td>
                            <td>{{ ucfirst($inspection->status) }}</td>
                            <td>{{ $inspection->active ? 'Oui' : 'Non' }}</td>
                            <td>
                                <a href="{{ route('admin.inspections.show', $inspection->id) }}"
                                    class="btn btn-info btn-sm">Voir</a>
                                <a href="{{ route('admin.inspections.edit', $inspection->id) }}"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.inspections.destroy', $inspection->id) }}" method="POST"
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

            {{ $inspections->links() }}
        </section>
    </div>
@endsection
