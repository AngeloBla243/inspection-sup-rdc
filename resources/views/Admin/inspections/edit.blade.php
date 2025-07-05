@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <h1 class="mb-4">Modifier l'inspection</h1>
            <form method="POST" action="{{ route('admin.inspections.update', $inspection->id) }}">
                @csrf
                @method('PUT')
                @include('admin.inspections.form')
                <button type="submit" class="btn btn-success">Mettre à jour</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script>
        $('#inspectors').select2({
            placeholder: "Sélectionnez un ou plusieurs inspecteurs"
        });
    </script>
@endsection
