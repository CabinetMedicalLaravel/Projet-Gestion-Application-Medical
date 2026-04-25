<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
    'patient_id', 
    'medecin_id', 
    'motif', 
    'diagnostic', 
    'notes', 
    'traitement',
    'medicaments'
];

    public function patient()
{
    // On lie la consultation à un User (qui joue le rôle de patient)
    return $this->belongsTo(User::class, 'patient_id');
}

    public function ordonnance() {
        return $this->hasOne(Ordonnance::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }
}