<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\User;

Route::get('/', function () {
    if (Auth::check()) return redirect('/dashboard');
    return view('welcome');
    
});

 


Route::get('/consultation/create/{patient}', [ConsultationController::class, 'create'])->name('consultation.create');


Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');

Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');

Route::get('/consultation/pdf/{id}', [ConsultationController::class, 'generatePDF'])
     ->name('consultation.pdf');

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
            'message' => " RDV dans moins de 24h — {$who} à " . $dt->format('H:i'),
            'date'    => $dt->translatedFormat('d M Y'),
            'type'    => 'warning',
        ];
    })->toArray();
}

Route::middleware(['auth', 'verified'])->group(function () {

    // ── PATIENT DASHBOARD ────────────────────────────────────────────────
    Route::get('/patient/dashboard', function () {
        if (Auth::user()->role !== 'patient') abort(403);
        $user = Auth::user();

        // Auto-expire past pending appointments
        Appointment::where('patient_id', $user->id)
            ->where('status', 'en_attente')
            ->where('appointment_date', '<', Carbon::now())
            ->update(['status' => 'annule']);

        $rdvs = Appointment::with('doctor')
            ->where('patient_id', $user->id)
            ->whereIn('status', ['en_attente', 'confirme'])
            ->orderBy('appointment_date')
            ->get();

        $rdv = $rdvs->map(function ($r) {
            $date = Carbon::parse($r->appointment_date);
            return [
                'jour'      => $date->format('d'),
                'mois'      => $date->translatedFormat('M'),
                'heure'     => $date->format('H:i'),
                'medecin'   => 'Dr. ' . ($r->doctor->name ?? '—'),
                'specialite'=> $r->doctor->specialite ?? 'Médecine générale',
                'statut'    => match($r->status) {
                    'en_attente' => 'En attente',
                    'confirme'   => 'Confirmé',
                    default      => 'À venir',
                },
            ];
        })->toArray();

        return view('dashboard', [
            'patient'       => $user,
            'rdv'           => $rdv,
            'notifications' => getNotifications('patient', $user->id),
            'nbOrdonnances' => 0,
        ]);
    })->name('patient.dashboard');




    // ── MÉDECIN DASHBOARD ────────────────────────────────────────────────

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

        $medecinId = Auth::id(); // Récupère l'ID du médecin actuellement connecté

        return view('medecin.dashboard', [

            // 1. Compte uniquement les patients qui ont eu une consultation avec CE médecin
            'nbPatients' => \App\Models\Consultation::where('medecin_id', $medecinId)
                    ->distinct('patient_id')
                    ->count(),
            // 2. Compte uniquement les consultations (ordonnances) de CE médecin
            'nbOrdonnances'    => \App\Models\Consultation::where('medecin_id', $medecinId)->count(),
            
            
            // 3. Affiche uniquement les derniers patients vus par CE médecin
            'derniersPatients' => \App\Models\User::whereHas('consultationsAsPatient', function($query) use ($medecinId) {
                                    $query->where('medecin_id', $medecinId);
                                })->latest()->take(5)->get(),
            

            'nbRdvAujourdhui'  => $rdvAujourdhuiRaw->count(),
            'nbPatients'       => $nbPatients,
            'nbEnAttente'      => $nbEnAttente,
            'rdvAujourdhui'    => $rdvAujourdhui,
            'derniersPatients' => $derniersPatients,
            'notifications'    => getNotifications('medecin', Auth::id()),

        ]);
    })->name('medecin.dashboard');

    // ── MÉDECIN AGENDA ───────────────────────────────────────────────────
    Route::get('/medecin/agenda', function () {
        if (Auth::user()->role !== 'medecin') abort(403);
        $query = Appointment::with('patient')->where('doctor_id', Auth::id())->orderBy('appointment_date','desc');
        if (request('statut')) $query->where('status', request('statut'));
        if (request('date'))   $query->whereDate('appointment_date', request('date'));
        $rdvs = $query->get();
        return view('medecin.agenda', compact('rdvs'));
    })->name('medecin.agenda');

    // ── SECRÉTAIRE DASHBOARD ─────────────────────────────────────────────
    Route::get('/secretaire/dashboard', function () {
        if (Auth::user()->role !== 'secretaire') abort(403);
        $today = Carbon::today();

        $rdvAujourdhuiRaw = Appointment::with(['patient','doctor'])
            ->whereDate('appointment_date', $today)->orderBy('appointment_date')->get();

        $rdvEnAttenteRaw = Appointment::with(['patient','doctor'])
            ->where('status', 'en_attente')->orderBy('appointment_date')->take(10)->get();

        $nbNouveauxPatients = User::where('role','patient')->where('created_at','>=',Carbon::now()->startOfMonth())->count();
        $nbMedecins         = User::where('role','medecin')->count();

        $rdvAujourdhui = $rdvAujourdhuiRaw->map(fn($r) => [
            'heure'   => Carbon::parse($r->appointment_date)->format('H:i'),
            'patient' => $r->patient_display_name,
            'medecin' => 'Dr. ' . ($r->doctor->name ?? '—'),
            'statut'  => $r->status,
        ])->toArray();

        $rdvEnAttente = $rdvEnAttenteRaw->map(fn($r) => [
            'patient' => $r->patient_display_name,
            'medecin' => 'Dr. ' . ($r->doctor->name ?? '—'),
            'date'    => Carbon::parse($r->appointment_date)->translatedFormat('d M Y'),
            'heure'   => Carbon::parse($r->appointment_date)->format('H:i'),
            'id'      => $r->id,
        ])->toArray();

        return view('secretaire.dashboard', [
            'nbRdvAujourdhui'    => $rdvAujourdhuiRaw->count(),
            'nbEnAttente'        => $rdvEnAttenteRaw->count(),
            'nbNouveauxPatients' => $nbNouveauxPatients,
            'nbMedecins'         => $nbMedecins,
            'rdvAujourdhui'      => $rdvAujourdhui,
            'rdvEnAttente'       => $rdvEnAttente,
            'notifications'      => getNotifications('secretaire', Auth::id()),
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



require __DIR__.'/auth.php';


