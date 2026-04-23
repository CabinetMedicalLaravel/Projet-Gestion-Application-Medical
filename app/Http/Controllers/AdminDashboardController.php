<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales (sans RendezVous ni Consultation)
        $stats = [
            'total_patients' => Patient::count(),
            'total_medecins' => User::where('role', 'medecin')->count(),
            'total_secretaires' => User::where('role', 'secretaire')->count(),
            'total_rendez_vous' => 0,
            'total_consultations' => 0,
            'patients_mois' => Patient::whereMonth('created_at', Carbon::now()->month)->count(),
            'rdv_mois' => 0,
        ];
        
        // Données pour les graphiques (valeurs par défaut)
        $rdvParMois = [
            'mois' => [],
            'count' => []
        ];
        
        $patientsParMois = [
            'count' => []
        ];
        
        // Remplir les 12 derniers mois pour les patients
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $mois = $date->locale('fr')->monthName;
            $count = Patient::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $rdvParMois['mois'][] = $mois . ' ' . $date->year;
            $rdvParMois['count'][] = 0; // Pas de RDV pour l'instant
            $patientsParMois['count'][] = $count;
        }
        
        // Statuts par défaut
        $statutLabels = ['confirmé', 'en attente', 'annulé', 'terminé'];
        $statutData = [0, 0, 0, 0];
        
        // Top médecins
        $medecins = User::where('role', 'medecin')->get();
        $medecinLabels = $medecins->pluck('name')->toArray();
        $medecinData = array_fill(0, count($medecins), 0);
        
        // Rendez-vous aujourd'hui (vide)
        $todayRdv = collect([]);
        
        // Derniers patients inscrits
        $latestPatients = Patient::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'stats', 'rdvParMois', 'patientsParMois', 'statutLabels', 'statutData',
            'medecinLabels', 'medecinData', 'todayRdv', 'latestPatients'
        ));
    }
}
