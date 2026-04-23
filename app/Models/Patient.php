<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    // Autoriser le remplissage des colonnes de votre table patients
    protected $fillable = ['nom', 'prenom', 'date_naissance', 'telephone'];
    protected $table = 'patients'; 
    
}
