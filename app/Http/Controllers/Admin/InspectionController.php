<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionController extends Controller
{
    public function index()
    {
        $inspections = Inspection::with(['university', 'inspector'])->paginate(10);
        return view('admin.inspections.index', compact('inspections'));
    }

    public function create()
    {
        $universities = University::all();
        $inspectors = User::where('user_type', 2)->get(); // Inspecteurs
        return view('admin.inspections.create', compact('universities', 'inspectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'university_id' => 'required|exists:universities,id',
            'inspector_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'objective' => 'required|string|max:255',
            'status' => ['required', Rule::in(['à venir', 'en cours', 'terminée'])],
            'active' => 'required|boolean',
        ]);

        Inspection::create($request->all());

        return redirect()->route('admin.inspections.index')->with('success', 'Inspection ajoutée avec succès.');
    }

    public function show(Inspection $inspection)
    {
        $inspection->load('university', 'inspector', 'reports');
        return view('admin.inspections.show', compact('inspection'));
    }

    public function edit(Inspection $inspection)
    {
        $universities = University::all();
        $inspectors = User::where('user_type', 2)->get();
        return view('admin.inspections.edit', compact('inspection', 'universities', 'inspectors'));
    }

    public function update(Request $request, Inspection $inspection)
    {
        $request->validate([
            'university_id' => 'required|exists:universities,id',
            'inspector_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'objective' => 'required|string|max:255',
            'status' => ['required', Rule::in(['à venir', 'en cours', 'terminée'])],
            'active' => 'required|boolean',
        ]);

        $inspection->update($request->all());

        return redirect()->route('admin.inspections.index')->with('success', 'Inspection mise à jour avec succès.');
    }

    public function destroy(Inspection $inspection)
    {
        $inspection->delete();
        return redirect()->route('admin.inspections.index')->with('success', 'Inspection supprimée avec succès.');
    }
}
