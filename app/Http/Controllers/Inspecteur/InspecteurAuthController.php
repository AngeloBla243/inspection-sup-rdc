<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspecteurAuthController extends Controller
{
    // Affiche le formulaire de connexion inspecteur (vous pouvez réutiliser la même vue de login générale)
    public function showLoginForm()
    {
        return view('auth.login'); // ou une vue spécifique si vous voulez
    }

    // Traite la tentative de connexion inspecteur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'user_type' => ['required', 'integer'],
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'user_type' => 2, // Forcer inspecteur
        ])) {
            $request->session()->regenerate();

            return redirect()->intended('/inspecteur/dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects ou type utilisateur invalide.',
        ])->onlyInput('email');
    }

    // Déconnexion inspecteur
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
