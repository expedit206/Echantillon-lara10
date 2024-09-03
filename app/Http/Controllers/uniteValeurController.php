<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Category;
use App\Models\Semestre;
use App\Models\Enseignant;
use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniteValeurController extends Controller
{
    public function index(Request $request)
    {
        $query = UniteValeur::query();

        if ($request->filled('niveau')) {
            $query->whereRelation('niveau', 'nom', $request->niveau);
        }

        if ($request->filled('filiere')) {
            $query->whereRelation('filiere', 'nom', $request->filiere);
        }

        if ($request->filled('unitevaleur')) {
            $query->where('nom', 'like', '%' . $request->unitevaleur . '%');
        }

        $unitevaleurs = $query->paginate(15);
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $uniteValeursAll = UniteValeur::all();
        $total = $query->count();

        return view('unitevaleur.index', compact('unitevaleurs','uniteValeursAll', 'niveaux', 'filieres', 'total'));
    }

    public function create()
    {
        // Récupération des données nécessaires pour le formulaire
        $niveaux = Niveau::all(); // Récupère tous les niveaux
        $filieres = Filiere::all(); // Récupère toutes les filières
        $enseignants = Enseignant::all(); // Récupère tous les enseignants
        $specialites = Specialite::all(); // Récupère toutes les spécialités
        $semestres = Semestre::all(); // Récupère tous les semestres
        $categories = Category::all(); // Récupère toutes les catégories

        // Retourne la vue 'unitevaleur.create' avec les données
        return view('unitevaleur.create', compact('niveaux', 'filieres', 'enseignants', 'specialites', 'semestres', 'categories'));
    }


    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit' => 'required|integer|min:1',
            'enseignant_id' => 'required|exists:enseignants,id',
            'filiere_id' => 'required|exists:filieres,id',
            'specialite_id' => 'required|exists:specialites,id',
            'niveau_id' => 'required|exists:niveaux,id',
            'semestre_id' => 'required|exists:semestres,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Création de l'unité de valeur avec les données validées
        UniteValeur::create([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'credit' => $request->input('credit'),
            'enseignant_id' => $request->input('enseignant_id'),
            'filiere_id' => $request->input('filiere_id'),
            'specialite_id' => $request->input('specialite_id'),
            'niveau_id' => $request->input('niveau_id'),
            'semestre_id' => $request->input('semestre_id'),
            'category_id' => $request->input('category_id'),
        ]);

        // Redirection avec un message de succès
        return redirect()->route('uniteValeur.index')->with('success', 'Unité de valeur créée avec succès.');
    }


    public function show(UniteValeur $uniteValeur)
    {
        // Assure-toi que toutes les relations nécessaires sont chargées pour éviter les N+1 queries
        $uniteValeur->load('niveau', 'filiere', 'specialite', 'enseignant');
    
        return view('unitevaleur.show', [
            'unitevaleur' => $uniteValeur
        ]);
    }
    
    public function edit(UniteValeur $uniteValeur)
    {
        // Récupère les listes de niveaux, filières, spécialités et enseignants pour les sélectionner dans le formulaire
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $specialites = Specialite::all();
        $enseignants = Enseignant::all();

        return view('unitevaleur.edit', compact('uniteValeur', 'niveaux', 'filieres', 'specialites', 'enseignants'));
    }

    public function update(Request $request, UniteValeur $uniteValeur)
    {
        // Validation des données
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
            'specialite_id' => 'required|exists:specialites,id',
            'enseignant_id' => 'nullable|exists:enseignants,id',
        ]);

        // Mise à jour des données
        $uniteValeur->update([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'niveau_id' => $request->input('niveau_id'),
            'filiere_id' => $request->input('filiere_id'),
            'specialite_id' => $request->input('specialite_id'),
            'enseignant_id' => $request->input('enseignant_id') ?: null, // Permettre la valeur null pour "Non attribué"
        ]);

        // Redirection vers la vue de détails avec un message de succès
        return redirect()->route('uniteValeur.show', $uniteValeur->id)
                         ->with('success', 'Unité de valeur mise à jour avec succès.');
    }
    public function destroy(UniteValeur $uniteValeur)
    {
        $uniteValeur->delete();

        return redirect()->route('uniteValeur.index')->with('success', 'Unité de valeur supprimée avec succès.');
    }
}
