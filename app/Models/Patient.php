<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['user_id', 'nom', 'prenom', 'date_naissance', 'adresse', 'telephone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}