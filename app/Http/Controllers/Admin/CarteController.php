<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class CarteController extends Controller
{
    public function index()
    {
        // Universités avec coordonnées
        $universities = University::select('id', 'name', 'gps_latitude', 'gps_longitude')->get();

        // Inspecteurs avec leur dernière position connue
        $inspectors = User::where('user_type', 2)
            ->whereNotNull('last_login_latitude')
            ->whereNotNull('last_login_longitude')
            ->select('id', 'name', 'last_login_latitude', 'last_login_longitude', 'email')
            ->get();

        return view('admin.carte.index', compact('universities', 'inspectors'));
    }
}
