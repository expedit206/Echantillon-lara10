<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $semestre_id = $request->semestre;
        $specialite_id = $request->specialite;
        $unite_de_valeur_id = $request->matieres;
        $niveau_id = $request->niveau;
        $annee_id = $request->annee;
        // Filtrer les étudiants avec les critères spécifiques
        $students = Etudiant::where('annee_id', $annee_id)
        ->where('specialite_id',$specialite_id)
        ->whereRelation('uniteValeurs','unite_valeur_id', $unite_de_valeur_id)
        ->whereRelation('notes.uniteValeur', 'niveau_id', $niveau_id)
        ->whereRelation('notes.uniteValeur', 'id', $unite_de_valeur_id)
        ->whereRelation('notes.uniteValeur', 'semestre_id', $semestre_id)
        ->whereRelation('notes.uniteValeur', 'specialite_id', $specialite_id)

         ->paginate(30);
        // foreach ($students as $student ) {
        //     echo('<br>'.$student->id);
        // }
        $semestre = Semestre::find($semestre_id);
        $annee_academique = $semestre->annee->nom ?? 'Année académique non spécifiée';

        return view('note.index', compact('students', 'semestre', 'annee_academique'));
    }

}
