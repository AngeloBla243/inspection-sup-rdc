<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InspecteurController extends Controller
{
    // Affiche la liste des inspecteurs
    public function list()
    {
        $inspecteurs = User::where('user_type', 2)->orderBy('id', 'desc')->paginate(10);
        return view('admin.inspecteur.list', compact('inspecteurs'));
    }



    // Affiche le formulaire d'ajout d'un inspecteur
    public function add()
    {
        return view('admin.inspecteur.add');
    }

    // Traite l'ajout d'un inspecteur
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['actif', 'suspendu'])],
            // Ajoutez des validations pour les champs spécifiques à l'inspecteur
        ]);

        $inspecteur = new User;
        $inspecteur->name = trim($request->name);
        $inspecteur->email = trim($request->email);
        $inspecteur->password = Hash::make($request->password);
        $inspecteur->user_type = 2; // Inspecteur
        $inspecteur->status = $request->status;


        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            // Générer un nom de fichier unique
            $filename = Str::slug($inspecteur->name) . '-' . time() . '.' . $request->file('profile_picture')->extension();

            // Stocker dans storage/app/public/profile_pictures
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            // Enregistrer le chemin relatif dans la base (sans "public/")
            $inspecteur->profile_picture = $path;
        }

        // Enregistrer d'autres champs spécifiques à l'inspecteur ici (ex: status, last_login_geolocation)
        // $inspecteur->status = $request->status; // Si vous avez un champ status
        // $inspecteur->last_login_geolocation = null; // À mettre à jour lors de la connexion

        $inspecteur->save();

        return redirect('admin/inspecteur/list')->with('success', 'Inspecteur ajouté avec succès.');
    }

    // Affiche le formulaire de modification d'un inspecteur
    public function edit($id)
    {
        $inspecteur = User::find($id);
        if (!$inspecteur || $inspecteur->user_type != 2) {
            abort(404);
        }
        return view('admin.inspecteur.edit', compact('inspecteur'));
    }

    // Traite la modification d'un inspecteur
    public function update(Request $request, $id)
    {
        $inspecteur = User::find($id);
        if (!$inspecteur || $inspecteur->user_type != 2) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($inspecteur->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['actif', 'suspendu'])],
            // Ajoutez des validations pour les champs spécifiques
        ]);

        $inspecteur->name = trim($request->name);
        $inspecteur->email = trim($request->email);
        if (!empty($request->password)) {
            $inspecteur->password = Hash::make($request->password);
        }
        $inspecteur->status = $request->status;

        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            // Générer un nom de fichier unique
            $filename = Str::slug($inspecteur->name) . '-' . time() . '.' . $request->file('profile_picture')->extension();

            // Stocker dans storage/app/public/profile_pictures
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            // Enregistrer le chemin relatif dans la base (sans "public/")
            $inspecteur->profile_picture = $path;
        }
        // Mettre à jour d'autres champs spécifiques à l'inspecteur

        $inspecteur->save();

        return redirect('admin/inspecteur/list')->with('success', 'Inspecteur mis à jour avec succès.');
    }

    // Supprime un inspecteur
    public function delete($id)
    {
        $inspecteur = User::find($id);
        if (!$inspecteur || $inspecteur->user_type != 2) {
            abort(404);
        }

        if ($inspecteur->profile_picture && Storage::disk('public')->exists($inspecteur->profile_picture)) {
            Storage::disk('public')->delete($inspecteur->profile_picture);
        }

        $inspecteur->delete();
        return redirect('admin/inspecteur/list')->with('success', 'Inspecteur supprimé avec succès.');
    }
}
