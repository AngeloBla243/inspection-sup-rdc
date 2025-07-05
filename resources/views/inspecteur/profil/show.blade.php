@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <h1>Mon profil</h1>
        <p>Nom : {{ $user->name }}</p>
        <p>Email : {{ $user->email }}</p>
        <p>Dernière position : {{ $user->last_login_latitude }}, {{ $user->last_login_longitude }}</p>
        {{-- <a href="{{ route('inspecteur.profil.edit') }}" class="btn btn-warning">Modifier mes infos</a>
        <a href="{{ route('inspecteur.profil.password') }}" class="btn btn-secondary">Changer mon mot de passe</a> --}}
    </div>
@endsection
