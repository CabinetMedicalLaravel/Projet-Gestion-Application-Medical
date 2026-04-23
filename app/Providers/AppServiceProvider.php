<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;  // ← ajouter cette ligne
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistrez tous les services d'application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialisez tous les services d'application.
     */
    public function boot(): void
    {
        // 1. Fix pour les anciennes versions de MySQL (évite les erreurs de longueur de clé lors des migrations)
        Schema::defaultStringLength(191);

        // 2. Configuration de Carbon pour afficher les dates en Français dans tes tableaux de bord
        // Exemple : "Lundi 22 Avril" au lieu de "Monday 22 April"
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        // 3. Utiliser le style Bootstrap 5 pour la pagination (si tu utilises $users->links())
        Paginator::useBootstrapFive();

        Route::bind('patient', function ($value) {
    return \App\Models\User::where('id', $value)
                           ->where('role', 'patient')
                           ->firstOrFail();
});
    }

    
}