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
        Schema::table('users', function (Blueprint $table) {
            // Rôle de l'utilisateur
            $table->enum('role', ['patient', 'medecin', 'secretaire'])
                  ->default('patient')
                  ->after('email');

            // Numéro de téléphone (optionnel pour médecin/secrétaire)
            $table->string('telephone', 20)
                  ->nullable()
                  ->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'telephone']);
        });
    }
};
