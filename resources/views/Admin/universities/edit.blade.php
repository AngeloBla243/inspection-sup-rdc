@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Modifier l'université / institut</h1>
        </section>

        <section class="content">
            <form action="{{ route('admin.universities.update', $university->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.universities.form')
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </section>
    </div>
@endsection
