<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status', // 'en_attente', 'confirme', 'annule', 'termine'
        'reason',
        'notes',
        'patient_name', // for walk-in patients without account (secretaire)
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /** Display name: registered patient or walk-in name */
    public function getPatientDisplayNameAttribute(): string
    {
        return $this->patient?->name ?? $this->patient_name ?? 'Patient inconnu';
    }

    /** Can médecin/secrétaire still cancel? (within 24h of creation is NOT the rule — 
     *  rule is: cannot cancel if appointment is less than 24h away) */
    public function canBeCancelledByStaff(): bool
    {
        return Carbon::now()->diffInHours($this->appointment_date, false) > 24;
    }

    /** Can be marked as "terminé"? Only if appointment time has passed */
    public function canBeMarkedDone(): bool
    {
        return Carbon::now()->isAfter($this->appointment_date);
    }

    /** Is within 24h from now? Used for notification badge */
    public function isWithin24h(): bool
    {
        $hours = Carbon::now()->diffInHours($this->appointment_date, false);
        return $hours >= 0 && $hours <= 24;
    }
}
