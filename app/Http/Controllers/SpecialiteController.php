<?php

use App\Http\Controllers\Controller;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;

class SpecialiteController extends Controller
{
    // Affichage du formulaire d'attribution
    public function showAssignUnite(Specialite $specialite)
    {
        $specialite = Specialite::findOrFail($specialite);
        $unites = UniteValeur::all(); // Récupère toutes les unités de valeur

        return view('specialite.assignUnite', compact('specialite', 'unites'));
    }

    // Gestion de l'attribution des unités de valeur
    public function assignUnite(Request $request,Specialite $specialite)
    {
        $specialite = Specialite::findOrFail($specialite);

        // Associe les unités de valeur sélectionnées à la spécialité
        $specialite->uniteValeurs()->sync($request->input('unite_de_valeurs', []));

        return redirect()->back()->with('success', 'Les unités de valeur ont été attribuées avec succès.');
    }
    
    public function selectUnite(Request $request)
{
    $validated = $request->validate([
        'niveau' => 'required|exists:niveaux,id',
        'specialite' => 'required|exists:specialites,id',
    ]);

    // Récupérer l'ID de la spécialité sélectionnée
    $specialiteId = $validated['specialite'];

    // Rediriger vers la route d'attribution des unités de valeur
    return redirect()->route('specialite.showAssignUnite', $specialiteId);
}

}

