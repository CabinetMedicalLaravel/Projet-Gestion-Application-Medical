<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check())
        return redirect('/dashboard');
    return view('welcome');
    
});


// On crée une route qui prend l'ID du patient en paramètre
Route::get('/consultation/create/{patient}', [ConsultationController::class, 'create'])->name('consultation.create');

// La route pour enregistrer le formulaire
Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');

Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');

Route::get('/consultation/pdf/{id}', [ConsultationController::class, 'generatePDF'])
     ->name('consultation.pdf');
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
    // --- ESPACE MÉDECIN ---
// --- ESPACE MÉDECIN ---
    Route::get('/medecin/dashboard', function () {
        if (Auth::user()->role !== 'medecin') abort(403);

        $medecinId = Auth::id(); // Récupère l'ID du médecin actuellement connecté

        return view('medecin.dashboard', [
            // 1. Compte uniquement les patients qui ont eu une consultation avec CE médecin
            'nbPatients' => \App\Models\Consultation::where('medecin_id', $medecinId)
                    ->distinct('patient_id')
                    ->count(),
            // 2. Compte uniquement les consultations (ordonnances) de CE médecin
            'nbOrdonnances'    => \App\Models\Consultation::where('medecin_id', $medecinId)->count(),
            
            'nbRdvAujourdhui'  => 0,
            'nbEnAttente'      => 0,
            'rdvAujourdhui'    => [],
            
            // 3. Affiche uniquement les derniers patients vus par CE médecin
            'derniersPatients' => \App\Models\User::whereHas('consultationsAsPatient', function($query) use ($medecinId) {
                                    $query->where('medecin_id', $medecinId);
                                })->latest()->take(5)->get(),
            
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