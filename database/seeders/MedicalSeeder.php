<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Creneau;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Nettoyage préalable (Optionnel mais conseillé pour le fresh)
        // Schema::disableForeignKeyConstraints();
        // ...

        // --- 1. ADMINISTRATEUR ---
        User::updateOrCreate(['email' => 'admin@test.com'], [
            'name' => 'Admin Cabinet',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // --- 2. MÉDECINS ---
        // Dr. Ahmed Alami
        $userDoc1 = User::updateOrCreate(['email' => 'doctor@test.com'], [
            'name' => 'Dr. Ahmed Alami',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);

        DB::table('medecins')->updateOrInsert(['user_id' => $userDoc1->id], [
            'specialite' => 'Cardiologie',
            'numero_ordre' => 'ORD12345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dr. Sara Mansouri
        $userDoc2 = User::updateOrCreate(['email' => 'sara@test.com'], [
            'name' => 'Dr. Sara Mansouri',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);

        DB::table('medecins')->updateOrInsert(['user_id' => $userDoc2->id], [
            'specialite' => 'Généraliste',
            'numero_ordre' => 'ORD67890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 3. DISPONIBILITÉS (CRÉNEAUX) ---
        // Dr. Ahmed (Lundi & Mercredi)
        foreach ([1, 3] as $jour) {
            Creneau::updateOrCreate([
                'medecin_id' => $userDoc1->id,
                'jour_semaine' => $jour,
                'heure_debut' => '09:00',
                'heure_fin' => '12:00',
            ], ['duree' => 30, 'est_actif' => true]);
        }

        // Dr. Sara (Mardi & Jeudi)
        foreach ([2, 4] as $jour) {
            Creneau::updateOrCreate([
                'medecin_id' => $userDoc2->id,
                'jour_semaine' => $jour,
                'heure_debut' => '14:00',
                'heure_fin' => '17:00',
            ], ['duree' => 20, 'est_actif' => true]);
        }

        // --- 4. SECRÉTAIRE ---
        User::updateOrCreate(['email' => 'secretaire@test.com'], [
            'name' => 'Secrétaire Sofia',
            'password' => Hash::make('password'),
            'role' => 'secretaire',
        ]);

        // --- 5. PATIENTS ---
        $userPat = User::updateOrCreate(['email' => 'patient@test.com'], [
            'name' => 'Yassine Benali',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        DB::table('patients')->updateOrInsert(['user_id' => $userPat->id], [
            'nom' => 'Benali',
            'prenom' => 'Yassine',
            'date_naissance' => '1990-05-15',
            'adresse' => 'Casablanca, Maroc',
            'telephone' => '0612345678',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 6. RENDEZ-VOUS ---
        // Un RDV pour demain avec Dr. Ahmed
        Appointment::updateOrCreate([
            'patient_id' => $userPat->id,
            'doctor_id' => $userDoc1->id,
            'appointment_date' => Carbon::tomorrow()->setTime(10, 0, 0),
        ], [
            'status' => 'confirme',
            'reason' => 'Check-up annuel cardiologie',
        ]);

        // Un RDV pour aujourd'hui avec Dr. Sara
        Appointment::updateOrCreate([
            'patient_id' => $userPat->id,
            'doctor_id' => $userDoc2->id,
            'appointment_date' => Carbon::today()->setTime(15, 0, 0),
        ], [
            'status' => 'en_attente',
            'reason' => 'Consultation grippe',
        ]);
    }
}