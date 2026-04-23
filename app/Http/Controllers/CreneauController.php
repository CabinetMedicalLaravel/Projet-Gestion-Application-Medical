<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Creneau;
use Illuminate\Http\Request;

class CreneauController extends Controller
{
    public function index(Request $request)
    {
        $medecins = User::where('role', 'medecin')->get();
        $medecinId = $request->get('medecin_id', $medecins->first()->id ?? null);
        
        $creneaux = [];
        if ($medecinId) {
            $creneaux = Creneau::where('medecin_id', $medecinId)->get()->groupBy('jour_semaine');
        }
        
        $jours = [
            1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 
            4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'
        ];
        
        return view('admin.creneaux.index', compact('medecins', 'creneaux', 'jours', 'medecinId'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:users,id',
            'jour_semaine' => 'required|integer|between:1,7',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'duree' => 'required|integer|min:15|max:120',
        ]);
        
        Creneau::create($validated);
        
        return redirect()->back()->with('success', 'Créneau ajouté avec succès.');
    }
    
    public function destroy(Creneau $creneau)
    {
        $creneau->delete();
        return redirect()->back()->with('success', 'Créneau supprimé.');
    }
    
    public function toggle(Creneau $creneau)
    {
        $creneau->update(['est_actif' => !$creneau->est_actif]);
        return redirect()->back()->with('success', 'Statut modifié.');
    }
}
