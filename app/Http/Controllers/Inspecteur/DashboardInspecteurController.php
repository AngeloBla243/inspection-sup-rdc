<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inspection;
use App\Models\Professor;

class DashboardInspecteurController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $prochainesInspections = Inspection::where('inspector_id', $user->id)
            ->whereIn('status', ['à venir', 'en cours'])
            ->orderBy('date')->limit(5)->get();

        $universitesInspectees = $user->inspections()->distinct('university_id')->count('university_id');
        $professeursEnregistres = Professor::whereHas('universities', function ($q) use ($user) {
            $q->whereIn('universities.id', $user->inspections()->pluck('university_id'));
        })->count();

        $dernierePosition = [
            'lat' => $user->last_login_latitude,
            'lng' => $user->last_login_longitude,
        ];

        return view('inspecteur.dashboard', compact('prochainesInspections', 'universitesInspectees', 'professeursEnregistres', 'dernierePosition'));
    }
}
