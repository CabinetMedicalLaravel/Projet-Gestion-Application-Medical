<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Creneau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PatientController;

// ─────────────────────────────────────────────
//  AUTHENTIFICATION
// ─────────────────────────────────────────────

// Page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Action connexion
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }
    return back()->withErrors(['email' => 'Identifiants incorrects.']);
})->name('login.post');

// Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ─────────────────────────────────────────────
//  ROUTES PROTÉGÉES (auth)
// ─────────────────────────────────────────────

Route::middleware(['auth'])->group(function () {

    // ── Patients (accessible admin + secrétaire) ──
    Route::resource('patients', PatientController::class);

});

// ─────────────────────────────────────────────
//  ROUTES ADMIN
// ─────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        $stats = [
            'users'        => DB::table('users')->count(),
            'medecins'     => DB::table('users')->where('role', 'medecin')->count(),
            'patients'     => DB::table('users')->where('role', 'patient')->count(),
            'secretaires'  => DB::table('users')->where('role', 'secretaire')->count(),
            'creneaux'     => DB::table('creneaux')->count(),
            'rdv_total'    => DB::table('rendez_vous')->count(),
            'rdv_attente'  => DB::table('rendez_vous')->where('statut', 'en_attente')->count(),
            'rdv_confirme' => DB::table('rendez_vous')->where('statut', 'confirme')->count(),
            'rdv_annule'   => DB::table('rendez_vous')->where('statut', 'annule')->count(),
            'consultations' => DB::table('consultations')->count(),
            'ordonnances'   => DB::table('ordonnances')->count(),
        ];

        $rdvParMois = DB::table('rendez_vous')
            ->selectRaw('MONTH(date) as mois, YEAR(date) as annee, COUNT(*) as total')
            ->whereRaw('date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)')
            ->groupByRaw('YEAR(date), MONTH(date)')
            ->orderByRaw('YEAR(date), MONTH(date)')
            ->get();

        $rdvParMedecin = DB::table('rendez_vous')
            ->join('users', 'rendez_vous.medecin_id', '=', 'users.id')
            ->selectRaw('users.name, COUNT(*) as total')
            ->groupBy('users.name')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', compact('stats', 'rdvParMois', 'rdvParMedecin'));
    })->name('admin.dashboard');

    // 1. Liste des utilisateurs
    Route::get('/admin/users', function (Request $request) {
        $role = $request->query('role', 'all');
        $query = User::query();
        if ($role !== 'all') {
            $query->where('role', $role);
        }
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users', 'role'));
    })->name('admin.users');

    // 2. Afficher la page Créer utilisateur
    Route::get('/admin/users/create', function () {
        return view('admin.users.create');
    })->name('admin.users.create');

    // 3. Enregistrer l'utilisateur
    Route::post('/admin/users/store', function (Request $request) {
        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'email_verified_at' => now(),
        ]);
        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès !');
    })->name('admin.users.store');

    // 4. Gestion des Créneaux - Liste
    Route::get('/admin/creneaux', function () {
        $medecins = User::where('role', 'medecin')->get();
        $medecin_id = request('medecin_id', $medecins->first()?->id);
        $creneaux = Creneau::where('medecin_id', $medecin_id)
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get();
        return view('admin.creneaux.index', compact('medecins', 'creneaux', 'medecin_id'));
    })->name('admin.creneaux');

    // 5. Ajouter un créneau
    Route::post('/admin/creneaux/store', function (Request $request) {
        Creneau::create([
            'medecin_id'   => $request->medecin_id,
            'jour_semaine' => $request->jour_semaine,
            'heure_debut'  => $request->heure_debut,
            'heure_fin'    => $request->heure_fin,
            'duree'        => $request->duree ?? 30,
            'est_actif'    => true,
        ]);
        return back()->with('success', 'Créneau ajouté avec succès !');
    })->name('admin.creneaux.store');

    // 6. Activer / Désactiver un créneau
    Route::post('/admin/creneaux/{creneau}/toggle', function (Creneau $creneau) {
        $creneau->update(['est_actif' => !$creneau->est_actif]);
        return back()->with('success', 'Statut mis à jour !');
    })->name('admin.creneaux.toggle');

    // 7. Supprimer un créneau
    Route::delete('/admin/creneaux/{creneau}', function (Creneau $creneau) {
        $creneau->delete();
        return back()->with('success', 'Créneau supprimé !');
    })->name('admin.creneaux.delete');

});