<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;

class HistoriqueInspectionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Utilise la relation latestReport pour récupérer le dernier rapport
        $query = Inspection::with(['university', 'latestReport'])
            // Pour plusieurs inspecteurs par inspection :
            ->whereHas('inspectors', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        if ($request->filled('university')) {
            $query->where('university_id', $request->university);
        }

        $inspections = $query->orderByDesc('date')->paginate(10);

        // Liste des universités où l’inspecteur a été affecté
        $universities = \App\Models\University::whereIn(
            'id',
            Inspection::whereHas('inspectors', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->pluck('university_id')
        )->orderBy('name')->get();

        return view('inspecteur.historique.index', compact('inspections', 'universities'));
    }
}
