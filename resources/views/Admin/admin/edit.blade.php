@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Modifier l'Administrateur</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form action="{{ route('admin.admin.update', $admin->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $admin->name) }}" placeholder="Entrez le nom">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', $admin->email) }}" placeholder="Entrez l'email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe (laissez vide si inchangé)</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Entrez le mot de passe">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirmez le mot de passe">
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">Statut</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="actif"
                                        {{ old('status', $inspecteur->status) == 'actif' ? 'selected' : '' }}>Actif
                                    </option>
                                    <option value="suspendu"
                                        {{ old('status', $inspecteur->status) == 'suspendu' ? 'selected' : '' }}>Suspendu
                                    </option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="profile_picture">Photo de profil</label>
                                @if ($admin->profile_picture)
                                    <div class="mb-2">
                                        <img src="{{ $admin->profile_picture_url }}" class="img-thumbnail"
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="profile_picture"
                                            id="profile_picture">
                                        <label class="custom-file-label" for="profile_picture">Choisir un fichier</label>
                                    </div>
                                </div>
                                @error('profile_picture')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
@endsection
