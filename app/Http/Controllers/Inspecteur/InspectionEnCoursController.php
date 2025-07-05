<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\Document;

class InspectionEnCoursController extends Controller
{
    public function show($id)
    {
        $inspection = Inspection::with(['university.professors'])->findOrFail($id);
        return view('inspecteur.inspections.form', compact('inspection'));
    }

    public function update(Request $request, $id)
    {
        $inspection = Inspection::findOrFail($id);

        // Validation de base (tu peux ajouter plus de règles)
        $request->validate([
            'signature' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'prof_documents.*.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'univ_documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // 1. Pièces jointes générales (photos)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('documents', 'public');
                    Document::create([
                        'name' => $file->getClientOriginalName(),
                        'file' => $path,
                        'type' => 'photo',
                        'university_id' => $inspection->university_id,
                        'inspection_id' => $inspection->id,
                    ]);
                }
            }
        }


        // 2. Scans/documents pour chaque professeur
        if ($request->hasFile('prof_documents')) {
            foreach ($request->file('prof_documents') as $profId => $files) {
                foreach ($files as $file) {
                    $path = $file->store('documents', 'public');
                    Document::create([
                        'name' => $file->getClientOriginalName(),
                        'file' => $path,
                        'type' => 'scan',
                        'professor_id' => $profId,
                        'inspection_id' => $inspection->id,
                    ]);
                }
            }
        }

        // 3. Scans/documents pour l’université
        if ($request->hasFile('univ_documents')) {
            foreach ($request->file('univ_documents') as $file) {
                $path = $file->store('documents', 'public');
                Document::create([
                    'name' => $file->getClientOriginalName(),
                    'file' => $path,
                    'type' => 'scan',
                    'university_id' => $inspection->university_id,
                    'inspection_id' => $inspection->id,
                ]);
            }
        }

        // 4. Signature et coordonnées GPS
        $inspection->signature = $request->signature;
        $inspection->gps_latitude = $request->gps_latitude;
        $inspection->gps_longitude = $request->gps_longitude;
        $inspection->status = 'terminée';
        $inspection->save();

        return redirect()
            ->route('inspecteur.inspections.index')
            ->with('success', 'Inspection validée et documents/scans enregistrés.');
    }
}
