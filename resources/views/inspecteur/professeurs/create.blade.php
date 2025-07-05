@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4">Ajouter un professeur / ouvrier</h1>

                <div class="card card-primary">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('inspecteur.professeurs.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="matricule">Matricule <span class="text-danger">*</span></label>
                                <input type="text" id="matricule" name="matricule" value="{{ old('matricule') }}"
                                    class="form-control @error('matricule') is-invalid @enderror" required>
                                @error('matricule')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Nom <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Statut <span class="text-danger">*</span></label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un statut --</option>
                                    <option value="Prof ordinaire"
                                        {{ old('status') == 'Prof ordinaire' ? 'selected' : '' }}>Prof ordinaire</option>
                                    <option value="associé" {{ old('status') == 'associé' ? 'selected' : '' }}>Associé
                                    </option>
                                    <option value="chef de travaux"
                                        {{ old('status') == 'chef de travaux' ? 'selected' : '' }}>Chef de travaux</option>
                                    <option value="ouvrier" {{ old('status') == 'ouvrier' ? 'selected' : '' }}>Ouvrier
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="custom-file">
                                    <input type="file" id="photo" name="photo"
                                        class="custom-file-input @error('photo') is-invalid @enderror" accept="image/*">
                                    <label class="custom-file-label" for="photo">Choisir un fichier</label>
                                </div>
                                @error('photo')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="universities">Universités d’affectation <span
                                        class="text-danger">*</span></label>
                                <select id="universities" name="universities[]"
                                    class="form-control select2 @error('universities') is-invalid @enderror"
                                    multiple="multiple" required style="width: 100%;">
                                    @foreach ($universities as $univ)
                                        <option value="{{ $univ->id }}"
                                            {{ collect(old('universities'))->contains($univ->id) ? 'selected' : '' }}>
                                            {{ $univ->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('universities')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            <a href="{{ route('inspecteur.professeurs.index') }}"
                                class="btn btn-secondary ml-2">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Initialiser Select2 -->
    <script>
        $(document).ready(function() {
            $('#universities').select2({
                placeholder: "Sélectionnez une ou plusieurs universités",
                allowClear: true
            });

            // Pour afficher le nom du fichier choisi dans le custom-file-input
            bsCustomFileInput.init();
        });
    </script>
@endsection
