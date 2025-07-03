<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Affiche le formulaire de connexion admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Traite la tentative de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'user_type' => ['required', 'integer'], // ajouter la validation du user_type
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'user_type' => $credentials['user_type'],
        ])) {
            $request->session()->regenerate();

            if ($credentials['user_type'] == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($credentials['user_type'] == 2) {
                return redirect()->intended('/inspecteur/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects ou type utilisateur invalide.',
        ])->onlyInput('email');
    }


    // Déconnexion admin
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
