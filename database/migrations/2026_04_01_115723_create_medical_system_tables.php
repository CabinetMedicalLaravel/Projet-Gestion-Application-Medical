<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table Medecins (Indispensable avant les consultations)
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('specialite');
            $table->string('numero_ordre');
            $table->timestamps();
        });

        // 2. Table Secretaires
        Schema::create('secretaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
    $table->string('nom');
    $table->string('prenom');
    $table->string('telephone')->nullable();
    $table->timestamps();
});

        // 3. Table RendezVous (Liaison vers USERS pour le patient)
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->date('date');
            $table->time('heure');
            $table->string('statut')->default('en_attente');
            $table->timestamps();
        });

        // 4. Table Consultations (Une seule fois !)
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->text('diagnostic');
            $table->text('traitement');
            $table->text('medicaments')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 5. Table Ordonnances
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->text('contenu');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('rendez_vous');
        Schema::dropIfExists('secretaires');
        Schema::dropIfExists('medecins');
    }
};