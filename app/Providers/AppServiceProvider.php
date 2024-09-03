<?php

namespace App\Providers;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Matiere;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use App\Services\DataService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DataService::class, function ($app) {
            return new DataService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
   
    View::composer('components.layout', function ($view) {
        $view->with([
            'annees' => Annee::all(),
            'niveaux' => Niveau::all(),
            'specialites' => Specialite::all(),
            'semestres' => Semestre::all(),
            'uniteValeurs' => UniteValeur::all(),
        ]);
    });
}

}
