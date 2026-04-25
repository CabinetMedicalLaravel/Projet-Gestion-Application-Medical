<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medecin_id');
            $table->integer('jour_semaine');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('duree')->default(30);
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
            
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};
