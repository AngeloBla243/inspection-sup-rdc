<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionReport;
use Illuminate\Support\Facades\Storage;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Http\Request;

class InspectionReportController extends Controller
{
    public function index(Request $request)
    {
        $query = InspectionReport::with(['inspection.university', 'inspector']);

        // Filtrage par inspecteur
        if ($request->filled('inspector_id')) {
            $query->where('inspector_id', $request->inspector_id);
        }

        // Filtrage par établissement (université)
        if ($request->filled('university_id')) {
            $query->whereHas('inspection', function ($q) use ($request) {
                $q->where('university_id', $request->university_id);
            });
        }

        // Filtrage par date (exemple : date de création)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $reports = $query->paginate(10);

        $inspectors = User::where('user_type', 2)->get();
        $universities = \App\Models\University::all();

        return view('admin.inspection_reports.index', compact('reports', 'inspectors', 'universities'));
    }

    public function show(InspectionReport $inspectionReport)
    {
        $inspectionReport->load('inspection.university', 'inspector');
        return view('admin.inspection_reports.show', compact('inspectionReport'));
    }

    public function create()
    {
        $inspections = Inspection::with('university')->get();
        $inspectors = User::where('user_type', 2)->get();
        return view('admin.inspection_reports.create', compact('inspections', 'inspectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inspection_id' => 'required|exists:inspections,id',
            'inspector_id' => 'required|exists:users,id',
            'data' => 'required|string',
            'gps_position' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'electronic_signature' => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('inspection_reports', 'public');
        }

        InspectionReport::create([
            'inspection_id' => $request->inspection_id,
            'inspector_id' => $request->inspector_id,
            'data' => $request->data,
            'gps_position' => $request->gps_position,
            'attachment' => $path,
            'electronic_signature' => $request->electronic_signature,
        ]);

        return redirect()->route('admin.inspection_reports.index')->with('success', 'Rapport ajouté avec succès.');
    }

    public function edit(InspectionReport $inspectionReport)
    {
        $inspections = Inspection::with('university')->get();
        $inspectors = User::where('user_type', 2)->get();
        return view('admin.inspection_reports.edit', compact('inspectionReport', 'inspections', 'inspectors'));
    }

    public function update(Request $request, InspectionReport $inspectionReport)
    {
        $request->validate([
            'inspection_id' => 'required|exists:inspections,id',
            'inspector_id' => 'required|exists:users,id',
            'data' => 'required|string',
            'gps_position' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'electronic_signature' => 'nullable|string',
        ]);

        $path = $inspectionReport->attachment;
        if ($request->hasFile('attachment')) {
            // Supprimer ancien fichier si besoin
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('attachment')->store('inspection_reports', 'public');
        }

        $inspectionReport->update([
            'inspection_id' => $request->inspection_id,
            'inspector_id' => $request->inspector_id,
            'data' => $request->data,
            'gps_position' => $request->gps_position,
            'attachment' => $path,
            'electronic_signature' => $request->electronic_signature,
        ]);

        return redirect()->route('admin.inspection_reports.index')->with('success', 'Rapport mis à jour avec succès.');
    }

    public function destroy(InspectionReport $inspectionReport)
    {
        if ($inspectionReport->attachment && Storage::disk('public')->exists($inspectionReport->attachment)) {
            Storage::disk('public')->delete($inspectionReport->attachment);
        }
        $inspectionReport->delete();
        return redirect()->route('admin.inspection_reports.index')->with('success', 'Rapport supprimé avec succès.');
    }
}
