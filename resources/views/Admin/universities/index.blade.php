@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Liste des universités / instituts</h1>
            <a href="{{ route('admin.universities.create') }}" class="btn btn-primary mb-3">Ajouter une université</a>
        </section>

        <section class="content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Localisation</th>
                        <th>Agrément</th>
                        <th>Nombre de profs</th>
                        <th>Statut inspection</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($universities as $university)
                        <tr>
                            <td>{{ $university->name }}</td>
                            <td>{{ ucfirst($university->type) }}</td>
                            <td>{{ $university->location }}</td>
                            <td>{{ $university->agreement ? 'Oui' : 'Non' }}</td>
                            <td>{{ $university->professors_count }}</td>
                            <td>{{ ucfirst($university->inspection_status) }}</td>
                            <td>
                                <a href="{{ route('admin.universities.show', $university->id) }}"
                                    class="btn btn-info btn-sm">Détails</a>
                                <a href="{{ route('admin.universities.edit', $university->id) }}"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.universities.destroy', $university->id) }}" method="POST"
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

            {{ $universities->links() }}
        </section>
    </div>
@endsection
