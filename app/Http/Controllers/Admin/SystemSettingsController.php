<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        // Exemple : récupérer plusieurs paramètres
        $settings = [
            'app_name' => settings()->get('app_name', 'Mon Application'),
            'logo' => settings()->get('logo', null),
            'notifications_enabled' => settings()->get('notifications_enabled', true),
        ];

        return view('admin.system_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notifications_enabled' => 'required|boolean',
        ]);

        settings()->set('app_name', $request->app_name);
        settings()->set('notifications_enabled', $request->notifications_enabled);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            settings()->set('logo', $path);
        }

        // Suppression de settings()->save();

        return redirect()->route('admin.system_settings.index')->with('success', 'Paramètres mis à jour avec succès.');
    }
}
