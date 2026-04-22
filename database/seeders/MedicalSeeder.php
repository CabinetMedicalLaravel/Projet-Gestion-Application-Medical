<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use Illuminate\Support\Facades\Hash;

class MedicalSeeder extends Seeder
{
    /**
     * Exécute le remplissage de la base de données.
     */
    public function run(): void
    {
        // 1. Créer un Médecin (Compte utilisateur + Profil spécialisé)
        $userDoc = User::create([
            'name' => 'Dr. Ahmed Alami',
            'email' => 'doctor@test.com',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);

        Medecin::create([
            'user_id' => $userDoc->id,
            'specialite' => 'Cardiologie',
            'numero_ordre' => '12345',
        ]);

        // 2. Créer un Patient (Compte utilisateur + Profil détaillé)
        $userPat = User::create([
            'name' => 'Nouhaila Mezzi',
            'email' => 'nouhaila@test.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $userPat->id,
            'nom' => 'Mezzi',
            'prenom' => 'Nouhaila',
            'date_naissance' => '1998-01-01',
            'adresse' => 'Casablanca',
            'telephone' => '0600000000',
        ]);

        // 3. Créer une Secrétaire (Optionnel)
        User::create([
            'name' => 'Secrétaire Sofia',
            'email' => 'secretaire@test.com',
            'password' => Hash::make('password'),
            'role' => 'secretaire',
        ]);
    }
}