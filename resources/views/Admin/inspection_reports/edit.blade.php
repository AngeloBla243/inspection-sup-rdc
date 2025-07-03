@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ isset($inspectionReport) ? 'Modifier' : 'Ajouter' }} un rapport d'inspection</h1>
        </section>

        <section class="content">
            <form
                action="{{ isset($inspectionReport) ? route('admin.inspection_reports.update', $inspectionReport->id) : route('admin.inspection_reports.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($inspectionReport))
                    @method('PUT')
                @endif

                @include('admin.inspection_reports.form')

                <button type="submit"
                    class="btn btn-primary">{{ isset($inspectionReport) ? 'Mettre à jour' : 'Ajouter' }}</button>
            </form>
        </section>
    </div>
@endsection
