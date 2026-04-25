<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('consultations', function (Blueprint $table) {
        
        // 1. On essaie de supprimer l'ancienne clé étrangère si elle existe
        // supprimé car Schema::table différé empêche le try/catch de fonctionner correctement

        // 2. On change la destination de la clé vers la table 'users'
        $table->foreign('patient_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('consultations', function (Blueprint $table) {
        $table->dropForeign(['patient_id']);
        $table->foreign('patient_id')
              ->references('id')
              ->on('patients'); // Retour à l'état initial si on annule
    });
}
};
