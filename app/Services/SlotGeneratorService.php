<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Creneau;

class SlotGeneratorService
{
    protected array $defaultSlots = [
        '08:00','08:20','08:40','09:00','09:20','09:40',
        '10:00','10:20','10:40','11:00','11:20','11:40',
        '14:00','14:20','14:40','15:00','15:20','15:40',
        '16:00','16:20','16:40','17:00','17:20','17:40',
    ];

    /**
     * Génère les créneaux disponibles.
     */
    public function generate($doctorId, $date)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeekIso;
        
        $configs = Creneau::where('medecin_id', $doctorId)
            ->where('jour_semaine', $dayOfWeek)
            ->where('est_actif', true)
            ->get();

        if ($configs->isEmpty()) {
            $hasAnyConfig = Creneau::where('medecin_id', $doctorId)->exists();
            if (!$hasAnyConfig) {
                return $this->defaultSlots;
            }
            return [];
        }

        $slots = [];
        foreach ($configs as $config) {
            $start = Carbon::parse($config->heure_debut);
            $end   = Carbon::parse($config->heure_fin);
            $duree = $config->duree;

            while ($start->copy()->addMinutes($duree) <= $end) {
                $slots[] = $start->format('H:i');
                $start->addMinutes($duree);
            }
        }
        
        sort($slots);
        return array_values(array_unique($slots));
    }
}
