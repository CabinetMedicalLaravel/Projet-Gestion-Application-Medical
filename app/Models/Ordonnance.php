<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    // Ajoute cette ligne pour autoriser l'enregistrement du contenu
    protected $fillable = ['consultation_id', 'contenu', 'date'];
    // Relation inverse : Une ordonnance appartient à une consultation
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}