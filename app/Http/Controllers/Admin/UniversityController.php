<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::paginate(10);
        return view('admin.universities.index', compact('universities'));
    }

    public function create()
    {
        return view('admin.universities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:public,privé',
            'location' => 'required|string|max:255',
            'agreement' => 'required|boolean',
            'gps_latitude' => 'nullable|numeric',
            'gps_longitude' => 'nullable|numeric',
            'inspection_status' => 'required|in:à jour,en attente',
        ]);

        University::create($request->all());

        return redirect()->route('admin.universities.index')->with('success', 'Université ajoutée avec succès.');
    }

    public function show(University $university)
    {
        $university->load('professors', 'inspections');
        return view('admin.universities.show', compact('university'));
    }

    public function edit(University $university)
    {
        return view('admin.universities.edit', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:public,privé',
            'location' => 'required|string|max:255',
            'agreement' => 'required|boolean',
            'gps_latitude' => 'nullable|numeric',
            'gps_longitude' => 'nullable|numeric',
            'inspection_status' => 'required|in:à jour,en attente',
        ]);

        $university->update($request->all());

        return redirect()->route('admin.universities.index')->with('success', 'Université mise à jour avec succès.');
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('admin.universities.index')->with('success', 'Université supprimée avec succès.');
    }
}
