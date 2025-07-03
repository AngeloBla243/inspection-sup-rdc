<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::with('universities')->paginate(10);
        return view('admin.professors.index', compact('professors'));
    }

    public function create()
    {
        $universities = University::all();
        return view('admin.professors.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|unique:professors',
            'name' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Prof ordinaire', 'associé', 'chef de travaux', 'ouvrier'])],
            'universities' => 'nullable|array',
            'universities.*' => 'exists:universities,id',
        ]);

        $professor = Professor::create($request->only('matricule', 'name', 'status'));

        if ($request->has('universities')) {
            $professor->universities()->sync($request->universities);
        }

        return redirect()->route('admin.professors.index')->with('success', 'Professeur ajouté avec succès.');
    }

    public function show(Professor $professor)
    {
        $professor->load('universities');
        return view('admin.professors.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        $universities = University::all();
        $professor->load('universities');
        return view('admin.professors.edit', compact('professor', 'universities'));
    }

    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'matricule' => ['required', 'string', Rule::unique('professors')->ignore($professor->id)],
            'name' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Prof ordinaire', 'associé', 'chef de travaux', 'ouvrier'])],
            'universities' => 'nullable|array',
            'universities.*' => 'exists:universities,id',
        ]);

        $professor->update($request->only('matricule', 'name', 'status'));

        if ($request->has('universities')) {
            $professor->universities()->sync($request->universities);
        } else {
            $professor->universities()->detach();
        }

        return redirect()->route('admin.professors.index')->with('success', 'Professeur mis à jour avec succès.');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('admin.professors.index')->with('success', 'Professeur supprimé avec succès.');
    }
}
