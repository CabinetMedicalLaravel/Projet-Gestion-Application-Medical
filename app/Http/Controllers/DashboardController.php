<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        
        $stats = [
            'total_patients' => Patient::count(),
            'total_medecins' => User::where('role', 'medecin')->count(),
            'total_secretaires' => User::where('role', 'secretaire')->count(),
            'total_rendez_vous' => 0,
            'consultations_mois' => 0,
        ];
        
        $todayRdv = collect([]);
        $upcomingRdv = collect([]);
        
        $moisLabels = [];
        $rdvData = [];
        $statutLabels = [];
        $statutData = [];
        
        $roleStats = [];
        
        return view('dashboard', compact('stats', 'todayRdv', 'upcomingRdv', 
            'moisLabels', 'rdvData', 'statutLabels', 'statutData', 'role', 'roleStats'));
    }
}
