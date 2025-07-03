<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */


    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Vérifier le statut avant authentification
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'suspendu') {
            return back()->withErrors([
                'email' => 'Votre compte est suspendu.'
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Mettre à jour la géolocalisation
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->update([
                'last_login_latitude' => $request->input('latitude'),
                'last_login_longitude' => $request->input('longitude')
            ]);

            $userType = $user->user_type;

            if ($userType == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($userType == 2) {
                return redirect()->intended('/inspecteur/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
