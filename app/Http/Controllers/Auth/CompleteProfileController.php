<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompleteProfileController extends Controller
{
    /**
     * Afficher la page de sélection de spécialité pour le médecin.
     */
    public function show(): View
    {
        return view('auth.complete-profile');
    }

    /**
     * Enregistrer la spécialité et rediriger vers le dashboard médecin.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validation des données
        $request->validate([
            'specialite'       => ['required', 'string'],
            // 'autre_specialite' est obligatoire seulement si 'specialite' vaut 'autre'
            'autre_specialite' => ['nullable', 'string', 'required_if:specialite,autre', 'max:255'],
        ], [
            // Message d'erreur personnalisé
            'autre_specialite.required_if' => 'Veuillez préciser votre spécialité dans le champ "Autre".',
        ]);

        // 2. Récupérer l'utilisateur actuellement connecté
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 3. Déterminer la valeur finale de la spécialité
        // Si l'utilisateur a choisi "autre", on prend la valeur saisie manuellement
        $specialiteFinale = ($request->specialite === 'autre') 
            ? $request->autre_specialite 
            : $request->specialite;

        // 4. Mettre à jour l'utilisateur dans la base de données
        $user->update([
            'specialite' => $specialiteFinale,
        ]);

        // 5. Synchroniser aussi avec la table 'medecins' pour la cohérence des données
        \App\Models\Medecin::updateOrCreate(
            ['user_id' => $user->id],
            ['specialite' => $specialiteFinale]
        );

        // 6. Redirection finale vers le dashboard du médecin
        return redirect()->route('medecin.dashboard')
                         ->with('status', 'Profil complété avec succès !');
    }
}