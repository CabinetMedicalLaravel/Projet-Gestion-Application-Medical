<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function dashboard()
{
    $user = auth()->user();
    $patient = \App\Models\Patient::where('user_id', $user->id)->first();

    // On force l'initialisation à un tableau vide si rien n'est trouvé
    $ordonnances = [];

    if ($patient) {
        $ordonnances = \App\Models\Consultation::where('patient_id', $patient->id)->get();
    }

    // Le nom ici doit être EXACTEMENT le même que dans la vue
    return view('dashboard', compact('ordonnances'));
}
}