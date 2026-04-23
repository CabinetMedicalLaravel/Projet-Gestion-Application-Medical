<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On modifie la table 'users'
        Schema::table('users', function (Blueprint $table) {
            // On ajoute la colonne spécialité juste après la colonne rôle
            $table->string('specialite')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On supprime la colonne si on annule la migration
            $table->dropColumn('specialite');
        });
    }
};