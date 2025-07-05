<?php

namespace App\Http\Controllers\Inspecteur;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionPlanifieeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->inspections()->with('university');
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        if ($request->filled('status')) $query->where('status', $request->status);
        $inspections = $query->orderBy('date')->paginate(10);
        return view('inspecteur.inspections.index', compact('inspections'));
    }

    public function calendar()
    {
        return view('inspecteur.inspections.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $user = auth()->user();
        $inspections = \App\Models\Inspection::with('university')
            ->where('inspector_id', $user->id)
            ->get();

        $events = $inspections->map(function ($insp) {
            return [
                'title' => $insp->university->name . ' (' . ucfirst($insp->status) . ')',
                'start' => $insp->date->toDateString(),
                'color' => $insp->status == 'terminée' ? '#28a745' : ($insp->status == 'en cours' ? '#ffc107' : '#007bff'),
                'url' => route('inspecteur.inspections.form', $insp->id),
            ];
        });

        return response()->json($events);
    }
}
