<?php

namespace App\Services;

use App\Models\Annee;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Support\Facades\Auth;

class DataService
{
    public function getAllData()
    {
        // Récupérer l'utilisateur connecté
$enseignant=Auth::guard('enseignant')->user();
// dd($enseignant);
        if ($enseignant) {
            // Si l'utilisateur est un enseignant, récupérer uniquement les données liées à ses unités de valeur
            $unitesValeurs = UniteValeur::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->whereRelation('annee', 'is_active', true)
            ->paginate(20);
            
            //  dd( $unitesValeurs);

            // Filtrer les autres entités en fonction des unités de valeur de l'enseignant
            $niveaux = Niveau::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);})
                ->get();
                // dd($niveaux);

            $filieres = Filiere::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->get();
        // whereHas('uniteValeurs', function ($query) use ($unitesValeurs) {
        //     $query->whereIn('id', $unitesValeurs->pluck('id'))
        //     ->whereRelation('annee', 'is_active', true);

            $specialites = Specialite::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);})
                ->get();

            $semestres = Semestre::whereHas('uniteValeurs', function ($query) use ($enseignant) {
                $query->whereRelation('enseignants', 'enseignant_id', $enseignant->id);})
                ->get();

            return [
                'annees' => Annee::orderBy('created_at', 'desc')->get(),
                'semestres' => $semestres,
                'specialites' => $specialites,
                'niveaux' => $niveaux,
                'filieres' => $filieres,
                'uniteValeurs' => $unitesValeurs,
                'total' => $unitesValeurs->count(),
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
                'enseignants' => Enseignant::orderBy('created_at', 'desc')->get(),
                'total' => UniteValeur::count(),

            ];
        }
    }
}
