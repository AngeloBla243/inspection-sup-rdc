@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Paramètres du système</h1>
        </section>

        <section class="content">
            <form action="{{ route('admin.system_settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="app_name">Nom de l'application</label>
                    <input type="text" name="app_name" id="app_name" class="form-control"
                        value="{{ old('app_name', $settings['app_name']) }}" required>
                    @error('app_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="logo">Logo</label>
                    @if ($settings['logo'])
                        <div><img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo"
                                style="max-height: 100px;"></div>
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control-file">
                    @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notifications_enabled">Notifications</label>
                    <select name="notifications_enabled" id="notifications_enabled" class="form-control" required>
                        <option value="1" {{ $settings['notifications_enabled'] ? 'selected' : '' }}>Activées</option>
                        <option value="0" {{ !$settings['notifications_enabled'] ? 'selected' : '' }}>Désactivées
                        </option>
                    </select>
                    @error('notifications_enabled')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </section>
    </div>
@endsection
