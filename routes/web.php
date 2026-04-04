<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ── 1. ROUTE DE REDIRECTION (Point d'entrée après Login/Vérification) ──
// Cette route sert de "chef d'orchestre" pour envoyer chaque rôle au bon endroit.
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

    // --- ESPACE PATIENT ---
    Route::get('/patient/dashboard', function () {
        // Optionnel : Sécurité supplémentaire si pas de middleware global
        if (Auth::user()->role !== 'patient') abort(403); 

        return view('dashboard', [
            'patient'       => Auth::user(),
            'rdv'           => [],
            'notifications' => [],
            'nbOrdonnances' => 0,
        ]);
    })->name('patient.dashboard');

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
            'nbRdvAujourdhui'    => 0,
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