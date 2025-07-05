<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\Professor;
use App\Models\University;

class ProfesseurController extends Controller
{

    public function index(Request $request)
    {
        $query = Professor::with('universities');

        if ($request->filled('matricule')) {
            $query->where('matricule', 'like', '%' . $request->matricule . '%');
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('university')) {
            $query->whereHas('universities', function ($q) use ($request) {
                $q->where('universities.id', $request->university);
            });
        }

        $professors = $query->paginate(10);

        // Pour la liste déroulante des universités
        $universities = \App\Models\University::orderBy('name')->get();

        return view('inspecteur.professeurs.index', compact('professors', 'universities'));
    }


    public function create()
    {
        $universities = University::all();
        return view('inspecteur.professeurs.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:professors',
            'name' => 'required',
            'status' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'universities' => 'required|array',
        ]);
        $prof = Professor::create($request->only('matricule', 'name', 'status'));
        if ($request->hasFile('photo')) {
            $prof->photo = $request->file('photo')->store('professors', 'public');
            $prof->save();
        }
        $prof->universities()->sync($request->universities);
        return redirect()->route('inspecteur.professeurs.index')->with('success', 'Professeur ajouté.');
    }
}
