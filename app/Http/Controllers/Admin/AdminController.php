<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Affiche la liste des admins
    public function list()
    {
        $admins = User::where('user_type', 1)->orderBy('id', 'desc')->paginate(10);
        return view('admin.admin.list', compact('admins'));
    }

    // Affiche le formulaire d'ajout d'un admin
    public function add()
    {
        return view('admin.admin.add');
    }

    // Traite l'ajout d'un admin
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'status' => ['required', Rule::in(['actif', 'suspendu'])],
        ]);

        $admin = new User;
        $admin->name = trim($request->name);
        $admin->email = trim($request->email);
        $admin->password = Hash::make($request->password);
        $admin->user_type = 1; // Admin
        $admin->status = $request->status;

        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            // Générer un nom de fichier unique
            $filename = Str::slug($admin->name) . '-' . time() . '.' . $request->file('profile_picture')->extension();

            // Stocker dans storage/app/public/profile_pictures
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            // Enregistrer le chemin relatif dans la base (sans "public/")
            $admin->profile_picture = $path;
        }

        $admin->save();

        return redirect('admin/admin/list')->with('success', 'Administrateur ajouté avec succès.');
    }

    // Affiche le formulaire de modification d'un admin
    public function edit($id)
    {
        $admin = User::find($id);
        if (!$admin || $admin->user_type != 1) {
            abort(404);
        }
        return view('admin.admin.edit', compact('admin'));
    }

    // Traite la modification d'un admin
    public function update(Request $request, $id)
    {
        $admin = User::find($id);
        if (!$admin || $admin->user_type != 1) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed', // Password est optionnel lors de la modification
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['actif', 'suspendu'])],
        ]);

        $admin->name = trim($request->name);
        $admin->email = trim($request->email);
        $admin->status = $request->status;
        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            // Générer un nom de fichier unique
            $filename = Str::slug($admin->name) . '-' . time() . '.' . $request->file('profile_picture')->extension();

            // Stocker dans storage/app/public/profile_pictures
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            // Enregistrer le chemin relatif dans la base (sans "public/")
            $admin->profile_picture = $path;
        }

        $admin->save();

        return redirect('admin/admin/list')->with('success', 'Administrateur mis à jour avec succès.');
    }

    // Supprime un admin
    public function delete($id)
    {
        $admin = User::find($id);
        if (!$admin || $admin->user_type != 1) {
            abort(404);
        }

        // Supprimer la photo de profil associée
        if ($admin->profile_picture && Storage::disk('public')->exists($admin->profile_picture)) {
            Storage::disk('public')->delete($admin->profile_picture);
        }

        $admin->delete();
        return redirect('admin/admin/list')->with('success', 'Administrateur supprimé avec succès.');
    }
}
