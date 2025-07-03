@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Liste des professeurs et ouvriers</h1>
            <a href="{{ route('admin.professors.create') }}" class="btn btn-primary mb-3">Ajouter un professeur/ouvrier</a>
        </section>

        <section class="content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th>Affectations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professors as $professor)
                        <tr>
                            <td>{{ $professor->matricule }}</td>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->status }}</td>
                            <td>
                                @foreach ($professor->universities as $university)
                                    <span class="badge badge-info">{{ $university->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.professors.show', $professor->id) }}"
                                    class="btn btn-info btn-sm">Voir</a>
                                <a href="{{ route('admin.professors.edit', $professor->id) }}"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.professors.destroy', $professor->id) }}" method="POST"
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

            {{ $professors->links() }}
        </section>
    </div>
@endsection
