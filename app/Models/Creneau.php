<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;

    protected $table = 'creneaux';
    
    protected $fillable = ['medecin_id', 'jour_semaine', 'heure_debut', 'heure_fin', 'duree', 'est_actif'];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }
}
