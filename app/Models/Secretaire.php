<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaire extends Model
{
    use HasFactory;

    // Champs autorisés à être remplis
    protected $fillable = ['user_id', 'numero_bureau'];

    // Liaison : La secrétaire appartient à un Utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}