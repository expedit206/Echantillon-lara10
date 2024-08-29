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
        $unite_de_valeur_id = $request->unite_de_valeur;
        $niveau_id = $request->niveau;
        $annee_id = $request->annee;
        // Filtrer les étudiants avec les critères spécifiques
        $students = Etudiant::where('annee_id', $annee_id)
        ->whereRelation('notes', 'unite_valeur_id', 3)
        // ->where('niveau_id',$niveau_id)
        // ->where('specialite_id', $specialite_id)
        // ->where('annee_id', $annee_id)
        // $students = Etudiant::with(['notes' => function($query) use ($semestre_id, $specialite_id, $unite_de_valeur_id, $niveau_id) {
        //     $query->whereRelation('uniteValeur', function($q) use ($semestre_id, $specialite_id, $niveau_id) {
        //         $q->where('semestre_id', $semestre_id)
        //           ->where('specialite_id', $specialite_id)
        //           ->where('niveau_id', $niveau_id);
        //     })->where('unite_valeur_id', $unite_de_valeur_id);
         ->paginate(30);
        dd($students);
        $semestre = Semestre::find($semestre_id);
        $annee_academique = $semestre->annee->nom ?? 'Année académique non spécifiée';
    
        return view('note.index', compact('students', 'semestre', 'annee_academique'));
    }
    
}
