@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Ajouter une université / institut</h1>
        </section>

        <section class="content">
            <form action="{{ route('admin.universities.store') }}" method="POST">
                @csrf
                @include('admin.universities.form')
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </section>
    </div>
@endsection
