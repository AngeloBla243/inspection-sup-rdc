@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Détails du professeur / ouvrier</h1>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-body">
                    <p><strong>Matricule :</strong> {{ $professor->matricule }}</p>
                    <p><strong>Nom :</strong> {{ $professor->name }}</p>
                    <p><strong>Statut :</strong> {{ $professor->status }}</p>
                    <p><strong>Affectations :</strong></p>
                    <ul>
                        @foreach ($professor->universities as $university)
                            <li>{{ $university->name }}</li>
                        @endforeach
                    </ul>
                    <!-- Ajoutez ici historique d'inspection, modification, désactivation, archivage -->
                </div>
            </div>
        </section>
    </div>
@endsection
