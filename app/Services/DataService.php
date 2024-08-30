<?php

namespace App\Services;

use App\Models\Annee;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\UniteValeur;

class DataService
{
    public function getAllData()
    {
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
