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
            // On transforme ENUM en STRING pour accepter la valeur 'admin'
            $table->string('role')->default('patient')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On revient en arrière si besoin (optionnel)
            $table->enum('role', ['patient', 'medecin', 'secretaire'])->default('patient')->change();
        });
    }
};