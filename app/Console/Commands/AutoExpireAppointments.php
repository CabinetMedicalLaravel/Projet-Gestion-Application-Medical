<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoExpireAppointments extends Command
{
    protected $signature   = 'rdv:expire';
    protected $description = 'Auto-cancel past pending appointments';

    public function handle(): void
    {
        $count = Appointment::where('status', 'en_attente')
            ->where('appointment_date', '<', Carbon::now())
            ->update(['status' => 'annule']);

        $this->info("$count appointment(s) auto-cancelled.");
    }
}
