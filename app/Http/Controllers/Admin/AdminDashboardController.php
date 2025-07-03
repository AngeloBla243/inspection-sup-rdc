<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use App\Models\Professor;
use App\Models\Inspection;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total universités
        $totalUniversites = University::count();

        // Total inspecteurs (user_type = 2)
        $totalInspecteurs = User::where('user_type', 2)->count();

        // Total professeurs
        $totalProfesseurs = Professor::count();

        // Inspections planifiées (status = 'à venir' ou 'en cours')
        $inspectionsPlanifiees = Inspection::whereIn('status', ['à venir', 'en cours'])->count();

        // Dernières inspections réalisées (status = 'terminée'), avec relations
        $dernieresInspections = Inspection::with('university', 'inspector')
            ->where('status', 'terminée')
            ->orderByDesc('date')
            ->limit(5)
            ->get()
            ->map(function ($inspection) {
                return [
                    'universite' => $inspection->university->name ?? 'N/A',
                    'inspecteur' => $inspection->inspector->name ?? 'N/A',
                    'date' => $inspection->date->format('d/m/Y'),
                    'statut' => ucfirst($inspection->status),
                ];
            });

        // Alertes personnalisées (exemple : universités non inspectées depuis plus d’un an)
        $uninspectedSince = now()->subYear();

        $alertes = University::whereDoesntHave('inspections', function ($query) use ($uninspectedSince) {
            $query->where('date', '>=', $uninspectedSince);
        })->pluck('name')->map(function ($name) {
            return "Université {$name} non inspectée depuis plus d’un an";
        })->toArray();

        // Vous pouvez ajouter d'autres alertes ici...

        return view('admin.dashboard', compact(
            'totalUniversites',
            'totalInspecteurs',
            'totalProfesseurs',
            'inspectionsPlanifiees',
            'dernieresInspections',
            'alertes'
        ));
    }
}
