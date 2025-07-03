@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Modifier un professeur / ouvrier</h1>
        </section>

        <section class="content">
            <form action="{{ route('admin.professors.update', $professor->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.professors.form')
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </section>
    </div>
@endsection
