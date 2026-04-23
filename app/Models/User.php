<?php

namespace App\Models;

use App\Models\Medecin;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Importation décommentée
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // Ajouté pour ta migration
        'telephone', // Ajouté pour ta migration
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être convertis (castés).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Helper pour vérifier si l'utilisateur est un patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Helper pour vérifier si l'utilisateur est un médecin
     */
    public function isMedecin(): bool
    {
        return $this->role === 'medecin';
    }

    /**
     * Helper pour vérifier si l'utilisateur est une secrétaire
     */
    public function isSecretaire(): bool
    {
        return $this->role === 'secretaire';
    }
    public function medecin(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Medecin::class, 'user_id');
    }
    public function getSpecialiteAttribute(): ?string
    {
        return $this->medecin?->specialite;
    }
}