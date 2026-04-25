<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CompleteProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CreneauController;
use App\Models\User;
use App\Models\Creneau;
use App\Models\Appointment;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes - Cabinet Médical
|--------------------------------------------------------------------------
*/

// ── 0. ACCUEIL PUBLIC ───────────────────────────────────────────────────
Route::get('/', function () {
    // On récupère les médecins pour la liste sur welcome
    $medecins = User::where('role', 'medecin')->take(4)->get();
    return view('welcome', compact('medecins'));
});

// ── 1. REDIRECTION APRÈS CONNEXION (CERVEAU) ────────────────────────────
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    
    // Si c'est un médecin qui n'a pas encore choisi sa spécialité, on le force à le faire
    if ($user->role === 'medecin' && empty($user->specialite)) {
        return redirect()->route('complete-profile.show');
    }

    return match ($user->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        'medecin'    => redirect()->route('medecin.dashboard'),
        default      => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

// ── 2. FONCTIONS DE NOTIFICATION (HELPER) ──────────────────────────────
if (!function_exists('getDashboardNotifications')) {
    function getDashboardNotifications(string $role, int $userId): array {
        $query = Appointment::with(['doctor','patient'])
            ->whereIn('status', ['en_attente', 'confirme'])
            ->where('appointment_date', '>', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addHours(24));

        if ($role === 'patient')  $query->where('patient_id', $userId);
        if ($role === 'medecin')  $query->where('doctor_id', $userId);

        return $query->get()->map(fn($r) => [
            'message' => "RDV dans moins de 24h avec " . ($role === 'patient' ? 'Dr. '.$r->doctor->name : $r->patient_display_name),
            'date'    => Carbon::parse($r->appointment_date)->translatedFormat('d M Y'),
        ])->toArray();
    }
}

// ── 3. ROUTES PROTÉGÉES (Connectés) ─────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // --- ESPACE PATIENT ---
    Route::get('/patient/dashboard', function () {
        if (Auth::user()->role !== 'patient') abort(403);

        $userId = Auth::id();
        
        // Tous les RDV du patient
        $tousRdv = Appointment::with('doctor')
            ->where('patient_id', $userId)
            ->orderBy('appointment_date', 'asc')
            ->get();
            
        // Prochains RDV
        $prochainsRdvModel = $tousRdv->where('appointment_date', '>=', now());
        
        // Formatage pour la vue
        $rdvFormats = $prochainsRdvModel->map(function($r) {
            return [
                'jour' => \Carbon\Carbon::parse($r->appointment_date)->format('d'),
                'mois' => \Carbon\Carbon::parse($r->appointment_date)->translatedFormat('M'),
                'medecin' => $r->doctor->name ?? 'Inconnu',
                'specialite' => $r->doctor->specialite ?? 'Consultation',
                'heure' => \Carbon\Carbon::parse($r->appointment_date)->format('H:i'),
                'statut' => ucfirst($r->status),
            ];
        })->values()->toArray();

        // Nombre total de RDV (historique + futurs)
        $totalRdv = $tousRdv->count();

        // Nombre d'ordonnances
        $nbOrdonnances = \App\Models\Ordonnance::whereHas('consultation', function($q) use ($userId) {
            $q->where('patient_id', $userId);
        })->count();

        return view('dashboard', [
            'rdv' => $rdvFormats,
            'totalRdv' => $totalRdv,
            'notifications' => getDashboardNotifications('patient', $userId),
            'nbOrdonnances' => $nbOrdonnances,
        ]);
    })->name('patient.dashboard');

    Route::post('/support/send', [SupportController::class, 'store'])->name('support.store');

    // --- ESPACE MÉDECIN ---
    Route::middleware(['role:medecin'])->group(function () {
        Route::get('/medecin/dashboard', function () {
            $medecinId = Auth::id();
            
            // RDV d'aujourd'hui
            $rdvAujourdhui = Appointment::with('patient')
                ->where('doctor_id', $medecinId)
                ->whereDate('appointment_date', Carbon::today())
                ->orderBy('appointment_date', 'asc')
                ->get()
                ->map(fn($r) => [
                    'heure'  => $r->appointment_date->format('H:i'),
                    'patient' => $r->patient_display_name,
                    'motif'   => $r->reason,
                    'statut'  => $r->status === 'confirme' ? 'confirmé' : 'en attente',
                ]);

            // Derniers patients
            $derniersPatients = User::whereHas('consultationsAsPatient', fn($q) => $q->where('medecin_id', $medecinId))
                ->with(['consultationsAsPatient' => fn($q) => $q->where('medecin_id', $medecinId)->latest()])
                ->get()
                ->take(5);

            return view('medecin.dashboard', [
                'nbPatients'       => \App\Models\Consultation::where('medecin_id', $medecinId)->distinct('patient_id')->count(),
                'nbOrdonnances'    => \App\Models\Consultation::where('medecin_id', $medecinId)->count(),
                'nbRdvAujourdhui'  => $rdvAujourdhui->count(),
                'nbEnAttente'      => Appointment::where('doctor_id', $medecinId)->where('status', 'en_attente')->count(),
                'rdvAujourdhui'    => $rdvAujourdhui, 
                'derniersPatients' => $derniersPatients,
                'notifications'    => getDashboardNotifications('medecin', $medecinId),
            ]);
        })->name('medecin.dashboard');

        Route::get('/medecin/planning', [AppointmentController::class, 'planning'])->name('rdv.planning');

        Route::get('/medecin/api/rdv-aujourdhui', function () {
            $medecinId = Auth::id();
            $rdv = Appointment::with(['patient', 'doctor'])
                ->where('doctor_id', $medecinId)
                ->where('appointment_date', '>=', \Carbon\Carbon::now())
                ->whereIn('status', ['confirme', 'en_attente'])
                ->orderBy('appointment_date', 'asc')
                ->take(5)
                ->get()
                ->map(fn($r) => [
                    'heure'   => $r->appointment_date->format('d/m H:i'),
                    'patient' => $r->patient_display_name,
                    'motif'   => $r->reason,
                    'statut'  => $r->status === 'confirme' ? 'confirmé' : 'en attente',
                ]);
            return response()->json($rdv);
        })->name('medecin.api.rdv');

        Route::get('/complete-profile', [CompleteProfileController::class, 'show'])->name('complete-profile.show');
        Route::post('/complete-profile', [CompleteProfileController::class, 'store'])->name('complete-profile.store');
    });

    // --- ESPACE SECRÉTAIRE & GESTION PATIENTS ---
    Route::middleware(['role:admin,secretaire'])->group(function () {
        Route::get('/secretaire/dashboard', function () {
            $rdvAujourdhui = \App\Models\Appointment::with(['patient', 'doctor'])
                ->whereDate('appointment_date', \Carbon\Carbon::today())
                ->orderBy('appointment_date', 'asc')
                ->get()
                ->map(fn($r) => [
                    'id'      => $r->id,
                    'heure'   => $r->appointment_date->format('H:i'),
                    'patient' => $r->patient_display_name,
                    'medecin' => $r->doctor->name ?? 'Non assigné',
                    'motif'   => $r->reason,
                    'statut'  => $r->status,
                ]);

            $rdvEnAttente = \App\Models\Appointment::with(['patient', 'doctor'])
                ->where('status', 'en_attente')
                ->orderBy('appointment_date', 'asc')
                ->get()
                ->map(fn($r) => [
                    'id'      => $r->id,
                    'heure'   => $r->appointment_date->format('d/m H:i'),
                    'patient' => $r->patient_display_name,
                    'medecin' => $r->doctor->name ?? 'Non assigné',
                    'motif'   => $r->reason,
                ]);

            return view('secretaire.dashboard', [
                'messages'            => collect(),
                'nbRdvAujourdhui'     => $rdvAujourdhui->count(),
                'nbEnAttente'         => $rdvEnAttente->count(),
                'nbNouveauxPatients'  => \App\Models\User::where('role', 'patient')->whereDate('created_at', \Carbon\Carbon::today())->count(),
                'nbMedecins'          => \App\Models\User::where('role', 'medecin')->count(),
                'rdvEnAttente'        => $rdvEnAttente,
                'rdvAujourdhui'       => $rdvAujourdhui,
                'notifications'       => getDashboardNotifications('secretaire', Auth::id()),
            ]);
        })->name('secretaire.dashboard');

        Route::patch('/rdv/update-status/{appointment}', [AppointmentController::class, 'updateStatus'])->name('rdv.update-status');
        Route::get('/secretaire/rdv/create', [AppointmentController::class, 'createForPatient'])->name('secretaire.rdv.create');
        Route::resource('patients', PatientController::class);

        // --- GESTION DES UTILISATEURS (Accessible Admin & Secrétaire) ---
        Route::get('/admin/users', function(Request $request) {
            $role = $request->query('role', 'all');
            $users = ($role !== 'all') ? User::where('role', $role)->paginate(10) : User::paginate(10);
            return view('admin.users.index', compact('users', 'role'));
        })->name('admin.users');

        Route::get('/admin/users/create', fn() => view('admin.users.create'))->name('admin.users.create');
        Route::post('/admin/users/store', function(Request $request) {
            User::create(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password),'role'=>$request->role,'email_verified_at'=>now()]);
            return redirect()->route('admin.users')->with('success', 'Créé !');
        })->name('admin.users.store');
    });

    // --- ESPACE ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            $stats = [
                'users'         => User::count(),
                'medecins'      => User::where('role', 'medecin')->count(),
                'patients'      => User::where('role', 'patient')->count(),
                'secretaires'   => User::where('role', 'secretaire')->count(),
                'rdv_total'     => Appointment::count(),
                'rdv_attente'   => Appointment::where('status', 'en_attente')->count(),
                'rdv_confirme'  => Appointment::where('status', 'confirme')->count(),
                'rdv_annule'    => Appointment::where('status', 'annule')->count(),
                'consultations' => DB::table('consultations')->count(),
                'ordonnances'   => DB::table('ordonnances')->count(),
            ];

            // Données pour les graphiques
            $rdvParMois = Appointment::selectRaw('MONTH(appointment_date) as mois, YEAR(appointment_date) as annee, COUNT(*) as total')
                ->groupBy('mois', 'annee')
                ->orderBy('annee', 'desc')
                ->orderBy('mois', 'desc')
                ->take(6)
                ->get()
                ->reverse()
                ->values();

            $rdvParMedecin = Appointment::join('users', 'appointments.doctor_id', '=', 'users.id')
                ->selectRaw('users.name, COUNT(*) as total')
                ->groupBy('users.name')
                ->get();

            return view('admin.dashboard', compact('stats', 'rdvParMois', 'rdvParMedecin'));
        })->name('admin.dashboard');

        // --- GESTION DES CRÉNEAUX ---
        Route::get('/admin/creneaux', [CreneauController::class, 'index'])->name('admin.creneaux');
        Route::post('/admin/creneaux/store', [CreneauController::class, 'store'])->name('admin.creneaux.store');
        Route::post('/admin/creneaux/toggle/{creneau}', [CreneauController::class, 'toggle'])->name('admin.creneaux.toggle');
        Route::delete('/admin/creneaux/{creneau}', [CreneauController::class, 'destroy'])->name('admin.creneaux.delete');
    });

    // --- MODULES MÉDICAUX (RDV & CONSULTATIONS) ---
    Route::get('/rdv/calendrier', [AppointmentController::class, 'calendrier'])->name('rdv.calendrier');
    Route::get('/rdv/planning', [AppointmentController::class, 'planning'])->name('rdv.planning');
    Route::get('/rdv/mes-rdv', [AppointmentController::class, 'index'])->name('rdv.mes-rdv');
    Route::get('/rdv/prendre', [AppointmentController::class, 'create'])->name('rdv.create');
    Route::post('/rdv', [AppointmentController::class, 'store'])->name('rdv.store');
    Route::get('/rdv/edit/{appointment}', [AppointmentController::class, 'edit'])->name('rdv.edit');
    Route::patch('/rdv/update/{appointment}', [AppointmentController::class, 'update'])->name('rdv.update');
    Route::patch('/rdv/annuler/{appointment}', [AppointmentController::class, 'annuler'])->name('rdv.annuler');
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultation/create/{patient?}', [ConsultationController::class, 'create'])->name('consultation.create');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');
    Route::get('/consultation/pdf/{id}', [ConsultationController::class, 'generatePDF'])->name('consultation.pdf');

    Route::get('/patient/dossier', function () {
        if (Auth::user()->role !== 'patient') abort(403);
        $userId = Auth::id();
        $consultations = \App\Models\Consultation::with(['medecin', 'ordonnance'])
            ->where('patient_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('patient.dossier', compact('consultations'));
    })->name('patient.dossier');

    Route::get('/patient/ordonnances', function () {
        if (Auth::user()->role !== 'patient') abort(403);
        $userId = Auth::id();
        $ordonnances = \App\Models\Ordonnance::whereHas('consultation', function($q) use ($userId) {
            $q->where('patient_id', $userId);
        })->with('consultation.medecin')->get();
        return view('patient.ordonnances', compact('ordonnances'));
    })->name('patient.ordonnances');
});

// ── 4. PROFIL (Commun) ───────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── 5. CHARGEMENT DES ROUTES D'AUTHENTIFICATION (BREEZE) ────────────────
require __DIR__.'/auth.php';