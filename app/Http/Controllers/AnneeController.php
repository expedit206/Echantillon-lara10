<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;

class AnneeController extends Controller
{


    public function setActive(Request $request)
    {
        // Désactiver toutes les années
        \DB::table('annees')->update(['is_active' => false]);

        // Activer l'année sélectionnée
        \DB::table('annees')->where('id', $request->input('annee'))->update(['is_active' => true]);

        // Retourner une réponse JSON
        return response()->json(['success' => true]);
    }
}
