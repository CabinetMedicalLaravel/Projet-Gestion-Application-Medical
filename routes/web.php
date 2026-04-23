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
    if (Auth::check()) return redirect('/dashboard');
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
    return match (Auth::user()->role) {
        'medecin'    => redirect()->route('medecin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        default      => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

// Helper: build 24h notifications for any user
function getNotifications(string $role, int $userId): array {
    $query = Appointment::with(['doctor','patient'])
        ->whereIn('status', ['en_attente', 'confirme'])
        ->where('appointment_date', '>', Carbon::now())
        ->where('appointment_date', '<=', Carbon::now()->addHours(24))
        ->orderBy('appointment_date');

    if ($role === 'patient')  $query->where('patient_id', $userId);
    if ($role === 'medecin')  $query->where('doctor_id', $userId);
    // secretaire sees all

    return $query->get()->map(function($r) use ($role) {
        $dt  = Carbon::parse($r->appointment_date);
        $who = $role === 'patient'
            ? 'Dr. ' . ($r->doctor->name ?? '—')
            : ($r->patient_display_name);
        return [
            'message' => "⏰ RDV dans moins de 24h — {$who} à " . $dt->format('H:i'),
            'date'    => $dt->translatedFormat('d M Y'),
            'type'    => 'warning',
        ];
    })->toArray();
}

Route::middleware(['auth', 'verified'])->group(function () {

    // --- SPÉCIALITÉ MÉDECIN (Ajouté) ---
    // Cette page s'affiche juste après l'inscription du médecin
    Route::get('/complete-profile', [CompleteProfileController::class, 'show'])->name('complete-profile.show');
    Route::post('/complete-profile', [CompleteProfileController::class, 'store'])->name('complete-profile.store');

    // --- ESPACE PATIENT ---
    Route::get('/patient/dashboard', function () {
        if (Auth::user()->role !== 'patient') abort(403);

        return view('dashboard', [
            'patient'       => $user,
            'rdv'           => $rdv,
            'notifications' => getNotifications('patient', $user->id),
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
        $medecinId = Auth::id();
        $today     = Carbon::today();

        $rdvAujourdhuiRaw = Appointment::with('patient')
            ->where('doctor_id', $medecinId)
            ->whereDate('appointment_date', $today)
            ->whereIn('status', ['en_attente', 'confirme'])
            ->orderBy('appointment_date')->get();

        $nbEnAttente = Appointment::where('doctor_id', $medecinId)->where('status', 'en_attente')->count();
        $nbPatients  = Appointment::where('doctor_id', $medecinId)->whereIn('status', ['confirme','termine'])->distinct('patient_id')->count('patient_id');

        $derniersPatients = Appointment::with('patient')
            ->where('doctor_id', $medecinId)->where('status', 'termine')
            ->orderBy('appointment_date','desc')->take(5)->get()
            ->map(fn($r) => [
                'nom'                 => $r->patient_display_name,
                'date_derniere_visite'=> Carbon::parse($r->appointment_date)->translatedFormat('d M Y'),
            ])->toArray();

        $rdvAujourdhui = $rdvAujourdhuiRaw->map(fn($r) => [
            'heure'   => Carbon::parse($r->appointment_date)->format('H:i'),
            'patient' => $r->patient_display_name,
            'motif'   => $r->reason ?? '—',
            'statut'  => $r->status,
        ])->toArray();

        return view('medecin.dashboard', [
            'nbRdvAujourdhui'  => $rdvAujourdhuiRaw->count(),
            'nbPatients'       => $nbPatients,
            'nbEnAttente'      => $nbEnAttente,
            'nbOrdonnances'    => 0,
            'rdvAujourdhui'    => $rdvAujourdhui,
            'derniersPatients' => $derniersPatients,
            'notifications'    => getNotifications('medecin', Auth::id()),
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

    // ── MODULE RDV ───────────────────────────────────────────────────────
    Route::get('/rdv/calendrier',              [AppointmentController::class, 'calendrier'])->name('rdv.calendrier');
    Route::get('/rdv/prendre',                 [AppointmentController::class, 'create'])->name('rdv.create');
    Route::post('/rdv',                        [AppointmentController::class, 'store'])->name('rdv.store');
    Route::get('/rdv/mes-rdv',                 [AppointmentController::class, 'index'])->name('rdv.mes-rdv');
    Route::get('/rdv/{appointment}/modifier',  [AppointmentController::class, 'edit'])->name('rdv.edit');
    Route::put('/rdv/{appointment}',           [AppointmentController::class, 'update'])->name('rdv.update');
    Route::patch('/rdv/{appointment}/annuler', [AppointmentController::class, 'annuler'])->name('rdv.annuler');
    Route::get('/rdv/planning',                [AppointmentController::class, 'planning'])->name('rdv.planning');
    Route::patch('/rdv/{appointment}/statut',  [AppointmentController::class, 'updateStatus'])->name('rdv.statut');

    // ── SECRÉTAIRE: RDV pour un patient sans compte ──────────────────────
    Route::get('/secretaire/rdv/nouveau',      [AppointmentController::class, 'createForPatient'])->name('secretaire.rdv.create');
});

// ── PROFIL ────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
