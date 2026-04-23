<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CompleteProfileController; // Importation ajoutée
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── 0. PAGE D'ACCUEIL PUBLIQUE ──────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    // On récupère uniquement les utilisateurs qui sont des médecins
    $medecins = User::where('role', 'medecin')->get();

    return view('welcome', [
        'medecins' => $medecins
    ]);
});

// ── 1. ROUTE DE REDIRECTION (Point d'entrée après Login) ───────────────
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();

    return match ($user->role) {
        'medecin'    => redirect()->route('medecin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        'patient'    => redirect()->route('patient.dashboard'),
        default      => redirect('/'),
    };
})->name('dashboard');


// ── 2. GROUPES DE ROUTES PROTÉGÉS PAR RÔLE ─────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // --- SPÉCIALITÉ MÉDECIN (Ajouté) ---
    // Cette page s'affiche juste après l'inscription du médecin
    Route::get('/complete-profile', [CompleteProfileController::class, 'show'])->name('complete-profile.show');
    Route::post('/complete-profile', [CompleteProfileController::class, 'store'])->name('complete-profile.store');

    // --- ESPACE PATIENT ---
    Route::get('/patient/dashboard', function () {
        if (Auth::user()->role !== 'patient') abort(403);

        return view('dashboard', [
            'patient'       => Auth::user(),
            'rdv'           => [],
            'notifications' => [],
            'nbOrdonnances' => 0,
        ]);
    })->name('patient.dashboard');

    // Page d'accueil patient connecté (après clic sur le logo)
    Route::get('/patient/accueil', function () {
        if (Auth::user()->role !== 'patient') abort(403);

        return view('patient.accueil');
    })->name('patient.accueil');

    // --- ESPACE MÉDECIN ---
    Route::get('/medecin/dashboard', function () {
        if (Auth::user()->role !== 'medecin') abort(403);

        return view('medecin.dashboard', [
            'nbRdvAujourdhui'  => 0,
            'nbPatients'       => 0,
            'nbEnAttente'      => 0,
            'nbOrdonnances'    => 0,
            'rdvAujourdhui'    => [],
            'derniersPatients' => [],
            'notifications'    => [],
        ]);
    })->name('medecin.dashboard');

    // --- ESPACE SECRÉTAIRE ---
Route::get('/secretaire/dashboard', function () {
    if (Auth::user()->role !== 'secretaire') abort(403);



    return view('secretaire.dashboard', [
        'nbRdvAujourdhui'    => 0, // Garde tes variables actuelles
        'nbEnAttente'        => 0,
        'nbNouveauxPatients' => 0,
        'nbMedecins'         => 0,
        'rdvEnAttente'       => [],
        'rdvAujourdhui'      => [],
        'notifications'      => [],
    ]);
})->name('secretaire.dashboard');

});

// ── 3. PROFIL (Commun à tous les utilisateurs connectés) ───────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';