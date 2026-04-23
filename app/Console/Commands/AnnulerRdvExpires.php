<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvAnnuleAutoMail;   // On va créer ce mail

class AnnulerRdvExpires extends Command
{
    protected $signature = 'rdv:annuler-expires';
    protected $description = 'Annule automatiquement les RDV en attente dépassés de plus de 1 heure et envoie un email';

    public function handle()
    {
        $now = Carbon::now();

        // Récupérer les RDV en attente dépassés de plus de 1 heure
        $appointments = Appointment::where('status', 'en_attente')
            ->where('appointment_date', '<', $now->copy()->subHour()) // dépassé de plus de 1h
            ->with('patient') // pour pouvoir accéder aux infos du patient
            ->get();

        $count = 0;

        foreach ($appointments as $appointment) {
            // Annuler le RDV
            $appointment->update([
                'status' => 'annule',
                'updated_at' => $now
            ]);

            // Envoyer l'email au patient
            if ($appointment->patient && $appointment->patient->email) {
                Mail::to($appointment->patient->email)
                    ->queue(new RdvAnnuleAutoMail($appointment));
            }

            $count++;
        }

        $this->info("✅ $count rendez-vous ont été annulés automatiquement (dépassés de plus de 1h).");

        if ($count > 0) {
            $this->line("   → Exécuté à : " . $now->format('Y-m-d H:i:s'));
        } else {
            $this->line("   Aucune annulation nécessaire.");
        }
    }
}