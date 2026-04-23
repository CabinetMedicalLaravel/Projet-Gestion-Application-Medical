<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nom', 'prenom', 'date_naissance', 'adresse', 'telephone'];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAgeAttribute(): int
    {
        return $this->date_naissance->age;
    }

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
