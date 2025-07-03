@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ isset($inspection) ? 'Modifier' : 'Ajouter' }} une inspection</h1>
        </section>

        <section class="content">
            <form
                action="{{ isset($inspection) ? route('admin.inspections.update', $inspection->id) : route('admin.inspections.store') }}"
                method="POST">
                @csrf
                @if (isset($inspection))
                    @method('PUT')
                @endif

                @include('admin.inspections.form')

                <button type="submit" class="btn btn-primary">{{ isset($inspection) ? 'Mettre à jour' : 'Ajouter' }}</button>
            </form>
        </section>
    </div>
@endsection
