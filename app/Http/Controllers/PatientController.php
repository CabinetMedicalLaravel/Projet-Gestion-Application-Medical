<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    // Liste des patients avec recherche et filtres
    public function index(Request $request)
    {
        $query = User::where('role', 'patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->sort === 'nom') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort === 'ancien') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $patients = $query->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    // Formulaire création
    public function create()
    {
        return view('patients.create');
    }

    // Enregistrer
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'password'  => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'telephone'         => $request->telephone,
            'password'          => Hash::make($request->password),
            'role'              => 'patient',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient créé avec succès !');
    }

    // Fiche patient
    public function show($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    // Formulaire modification
    public function edit($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);
        return view('patients.create', compact('patient'));
    }

    // Mettre à jour
    public function update(Request $request, $id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'telephone' => 'required|string|max:20',
        ]);

        $patient->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $patient->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('patients.show', $id)->with('success', 'Patient modifié avec succès !');
    }

    // Historique médical
    public function historique($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);
        $consultations = [];
        $ordonnances   = [];
        return view('patients.historique', compact('patient', 'consultations', 'ordonnances'));
    }

    // Supprimer
    public function destroy($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé !');
    }
}
