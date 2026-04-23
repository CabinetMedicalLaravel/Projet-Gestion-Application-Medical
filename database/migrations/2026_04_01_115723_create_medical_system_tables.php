<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Patient Table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('adresse');
            $table->string('telephone');
            $table->timestamps();
        });

        // 2. Medecin Table
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialite');
            $table->string('numero_ordre');
            $table->timestamps();
        });

        // 3. Secretaire Table (Added based on your UML)
        Schema::create('secretaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 4. RendezVous Table
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('medecin_id')->constrained('medecins');
            $table->date('date');
            $table->time('heure');
            $table->string('statut')->default('en_attente');
            $table->timestamps();
        });

        // 5. Consultations
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('medecin_id')->constrained('medecins');
            $table->text('motif');
            $table->text('diagnostic');
            $table->timestamps();
        });

        // 6. Ordonnances (Composition from Consultation)
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->text('contenu');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key errors
        Schema::dropIfExists('ordonnances');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('rendez_vous');
        Schema::dropIfExists('secretaires');
        Schema::dropIfExists('medecins');
        Schema::dropIfExists('patients');
    }
};