@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Ajouter un professeur / ouvrier</h1>
        </section>

        <section class="content">
            <form action="{{ route('admin.professors.store') }}" method="POST">
                @csrf
                @include('admin.professors.form')
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </section>
    </div>
@endsection
