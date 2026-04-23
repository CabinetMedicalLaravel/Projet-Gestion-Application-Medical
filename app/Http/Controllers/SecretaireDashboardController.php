<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;
use Carbon\Carbon;

class SecretaireDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'consultations_aujourdhui' => Consultation::whereDate('date_consultation', Carbon::today())->count(),
            'patients_actifs' => Patient::count(),
            'rdv_a_confirmer' => RendezVous::where('statut', 'en attente')->count(),
            'ordonnances_mois' => 0,
        ];
        
        $consultations_aujourdhui = Consultation::with(['patient', 'medecin'])
            ->whereDate('date_consultation', Carbon::today())
            ->orderBy('date_consultation')
            ->get();
        
        return view('secretaire.dashboard', compact('stats', 'consultations_aujourdhui'));
    }
}
