<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllController extends Controller
{
  static public function all()
   {
       $annees = Annee::all();
       $semestres = Semestre::all();
       $specialites = Specialite::all();
       $matieres = UniteValeur::all();
       return([$annees,$semestres,$specialites,$matieres]);
    }
}
