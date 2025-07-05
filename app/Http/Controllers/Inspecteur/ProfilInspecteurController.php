<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilInspecteurController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('inspecteur.profil.show', compact('user'));
    }
    // Méthodes pour update mot de passe, photo, etc.
}
