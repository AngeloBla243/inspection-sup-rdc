<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InspecteurController;
use App\Http\Controllers\Inspecteur\InspecteurAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\InspectionReportController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Inspecteur\DashboardInspecteurController;
use App\Http\Controllers\Inspecteur\InspectionPlanifieeController;
use App\Http\Controllers\Inspecteur\InspectionEnCoursController;
use App\Http\Controllers\Inspecteur\ProfesseurController;
use App\Http\Controllers\Inspecteur\HistoriqueInspectionController;
use App\Http\Controllers\Inspecteur\ProfilInspecteurController;
use Illuminate\Support\Facades\Route;



// Route racine redirige vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route dashboard générique
Route::middleware('auth')->get('/dashboard', function () {
    $userType = Auth::user()->user_type;

    if ($userType == 1) {
        return redirect()->route('admin.dashboard');
    } elseif ($userType == 2) {
        return redirect()->route('inspecteur.dashboard');
    }

    abort(403);
})->name('dashboard');

// Routes admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Routes pour les Administrateurs
    Route::get('admin/list', [AdminController::class, 'list'])->name('admin.admin.list');
    Route::get('admin/add', [AdminController::class, 'add'])->name('admin.admin.add');
    Route::post('admin/add', [AdminController::class, 'insert'])->name('admin.admin.insert');
    Route::get('admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.admin.edit');
    Route::post('admin/edit/{id}', [AdminController::class, 'update'])->name('admin.admin.update');
    Route::get('admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.admin.delete'); // Utiliser POST ou DELETE pour des raisons de sécurité

    // Routes pour les Inspecteurs
    Route::get('inspecteur/list', [InspecteurController::class, 'list'])->name('admin.inspecteur.list');
    Route::get('inspecteur/add', [InspecteurController::class, 'add'])->name('admin.inspecteur.add');
    Route::post('inspecteur/add', [InspecteurController::class, 'insert'])->name('admin.inspecteur.insert');
    Route::get('inspecteur/edit/{id}', [InspecteurController::class, 'edit'])->name('admin.inspecteur.edit');
    Route::post('inspecteur/edit/{id}', [InspecteurController::class, 'update'])->name('admin.inspecteur.update');
    Route::get('inspecteur/delete/{id}', [InspecteurController::class, 'delete'])->name('admin.inspecteur.delete'); // Utiliser POST ou DELETE
    Route::resource('universities', UniversityController::class)->names('admin.universities');
    Route::resource('professors', ProfessorController::class)->names('admin.professors');
    Route::resource('inspections', InspectionController::class)->names('admin.inspections');
    Route::get('/admin/carte', [\App\Http\Controllers\Admin\CarteController::class, 'index'])->name('admin.carte');
    Route::resource('inspection_reports', InspectionReportController::class)->names('admin.inspection_reports');
    Route::get('system_settings', [SystemSettingsController::class, 'index'])->name('admin.system_settings.index');
    Route::post('system_settings', [SystemSettingsController::class, 'update'])->name('admin.system_settings.update');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Routes inspecteur
Route::prefix('inspecteur')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardInspecteurController::class, 'index'])->name('inspecteur.dashboard');
    Route::get('inspections', [InspectionPlanifieeController::class, 'index'])->name('inspecteur.inspections.index');
    Route::get('inspections/{id}/form', [InspectionEnCoursController::class, 'show'])->name('inspecteur.inspections.form');
    Route::post('inspections/{id}/form', [InspectionEnCoursController::class, 'update'])->name('inspecteur.inspections.update');
    Route::get('professeurs/create', [ProfesseurController::class, 'create'])->name('inspecteur.professeurs.create');
    Route::get('professeurs', [ProfesseurController::class, 'index'])->name('inspecteur.professeurs.index');
    Route::post('professeurs', [ProfesseurController::class, 'store'])->name('inspecteur.professeurs.store');
    Route::get('historique', [HistoriqueInspectionController::class, 'index'])->name('inspecteur.historique.index');
    Route::get('profil', [ProfilInspecteurController::class, 'show'])->name('inspecteur.profil.show');

    Route::get('inspecteur/calendrier', [InspectionPlanifieeController::class, 'calendar'])->name('inspecteur.inspections.calendar');
    Route::get('inspecteur/calendrier/events', [InspectionPlanifieeController::class, 'calendarEvents'])->name('inspecteur.inspections.calendar.events');


    Route::post('/logout', [InspecteurAuthController::class, 'logout'])->name('inspecteur.logout');
});







require __DIR__ . '/auth.php';
