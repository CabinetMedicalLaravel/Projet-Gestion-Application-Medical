<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon;
use App\Models\User;
class ConsultationController extends Controller
{
    // 1. AFFICHER LE FORMULAIRE
    public function create($id = null)
{
    // On récupère uniquement les utilisateurs avec le rôle 'patient'
    $patients = User::where('role', 'patient')->get();

    // On cherche le patient sélectionné (s'il y a un ID dans l'URL)
    $selectedPatient = $id ? User::find($id) : null;

    return view('consultations.create', compact('patients', 'selectedPatient'));
}

    // 2. ENREGISTRER LA CONSULTATION
    public function store(Request $request)
    {
        // A. Validation d'abord !
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'diagnostic' => 'required|string',
            'traitement' => 'required|string',
        ]);

        try {
            // B. Création de la consultation
            // On utilise auth()->id() pour lier automatiquement au médecin connecté
            $consultation = Consultation::create([
                'patient_id' => $request->patient_id,
                'medecin_id'  => auth()->id(), // auth()->id() est un raccourci plus rapide
                'diagnostic' => $request->diagnostic,
                'traitement' => $request->traitement,
                'notes'      => $request->notes, // Optionnel
                'medicaments'=> $request->medicaments,
                //On récupère l'ID du médecin actuellement connecté
                'medecin_id'  => auth()->user()->id,
            ]);

            // C. Gestion de l'ordonnance (si tu as une table séparée ou un champ texte)
            // Si c'est un champ "medicaments" dans la table consultations :
            if ($request->filled('medicaments')) {
                $consultation->update([
                    'medicaments' => $request->medicaments
                ]);
            }

            // D. REDIRECTION vers l'historique avec succès
            return redirect()->route('consultations.index')
                             ->with('success', 'La consultation a été enregistrée avec succès !');

     } catch (\Exception $e) {
        // ICI : Si ça plante, on veut voir le message exact (ex: colonne manquante)
        dd($e->getMessage()); 
    }
    }
    // Ajoute ceci dans ton ConsultationController.php
public function adminDashboard()
{
    // On compte les données réelles de la base de données
    $nbPatients = Patient::count();
    $nbOrdonnances = Consultation::whereNotNull('medicaments')->count();
    
    // Pour les RDV, si tu n'as pas encore de table, on laisse à 0
    $nbRdvAujourdhui = 0; 
    $nbEnAttente = 0;

    // On peut aussi récupérer les 5 derniers patients pour la liste
    $derniersPatients = Patient::latest()->take(5)->get()->map(function($p) {
        return [
            'nom' => $p->nom . ' ' . $p->prenom,
            'date_derniere_visite' => $p->created_at->format('d/m/Y')
        ];
    });

    return view('dashboard', compact(
        'nbPatients', 
        'nbOrdonnances', 
        'nbRdvAujourdhui', 
        'nbEnAttente',
        'derniersPatients'
    ));
}

    // 3. LISTE DES CONSULTATIONS (HISTORIQUE)
    public function index(Request $request) 
    {
        $search = $request->input('search');

        // On utilise le Eager Loading (with) pour éviter de ralentir la base de données
        $query = Consultation::with('patient');

        if ($search) {
            $query->where('diagnostic', 'LIKE', "%{$search}%")
                  ->orWhereHas('patient', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                  });
        }

        // Récupère uniquement les consultations créées par le médecin connecté
    $consultations = Consultation::where('medecin_id', auth()->id())
        ->with('patient') // Charge la relation patient pour afficher les noms
        ->latest()
        ->get();

    return view('consultations.index', compact('consultations'));;
    }

    // 4. GÉNÉRATION DU PDF
    public function generatePDF($id) 
    {
        $consultation = Consultation::with(['patient', 'user'])->findOrFail($id);

        $data = [
            'consultation' => $consultation,
            'doctor'       => $consultation->user,
            'patient'      => $consultation->patient,
            'date'         => Carbon::parse($consultation->created_at)->format('d/m/Y'),
        ];

        $pdf = PDF::loadView('consultations.ordonnance_pdf', $data);
        $fileName = 'ordonnance_' . strtolower($consultation->patient->nom) . '.pdf';

        return $pdf->stream($fileName);
    }
}