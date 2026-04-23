<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secretaires', function (Blueprint $table) {
            $table->id();
            // LA LIAISON : Clé étrangère vers la table users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Autres infos
            $table->string('numero_bureau')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secretaires');
    }
};