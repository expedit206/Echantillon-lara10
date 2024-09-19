<?php

namespace App\Services;

use App\Models\Annee;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\UniteValeur;
use Illuminate\Support\Facades\Auth;

class DataService
{
    public function getAllData()
    {
        // Récupérer l'utilisateur connecté
$user=Auth::guard('enseignant')->user();
        if ($user) {
            // Si l'utilisateur est un enseignant, récupérer uniquement les données liées à ses unités de valeur
            $unitesValeurs = UniteValeur::whereHas('enseignant', function ($query) use ($user) {
                $query->where('enseignant_id', $user->id);
            })->get();

            // Filtrer les autres entités en fonction des unités de valeur de l'enseignant
            $niveaux = Niveau::whereHas('uniteValeurs', function ($query) use ($unitesValeurs) {
                $query->whereIn('id', $unitesValeurs->pluck('id'));
            })->get();

            $filieres = Filiere::whereHas('uniteValeurs', function ($query) use ($unitesValeurs) {
                $query->whereIn('id', $unitesValeurs->pluck('id'));
            })->get();

            $specialites = Specialite::whereHas('uniteValeurs', function ($query) use ($unitesValeurs) {
                $query->whereIn('id', $unitesValeurs->pluck('id'));
            })->get();
dd($specialites);
            $semestres = Semestre::whereHas('uniteValeurs', function ($query) use ($unitesValeurs) {
                $query->whereIn('id', $unitesValeurs->pluck('id'));
            })->get();

            return [
                'annees' => Annee::orderBy('created_at', 'desc')->get(),
                'semestres' => $semestres,
                'specialites' => $specialites,
                'niveaux' => $niveaux,
                'filieres' => $filieres,
                'uniteValeurs' => $unitesValeurs,
            ];
        } else {
            // Si ce n'est pas un enseignant, retourner toutes les données
            return [
                'annees' => Annee::orderBy('created_at', 'desc')->get(),
                'semestres' => Semestre::orderBy('created_at', 'desc')->get(),
                'specialites' => Specialite::orderBy('created_at', 'desc')->get(),
                'niveaux' => Niveau::orderBy('created_at', 'desc')->get(),
                'filieres' => Filiere::orderBy('created_at', 'desc')->get(),
                'uniteValeurs' => UniteValeur::orderBy('created_at', 'desc')->get(),
            ];
        }
    }
}
