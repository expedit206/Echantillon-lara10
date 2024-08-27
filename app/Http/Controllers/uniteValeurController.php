<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Filiere;
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

        $unitevaleurs = $query->paginate(10);
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $uniteValeursAll = UniteValeur::all();
        $total = $query->count();

        return view('unitevaleur.index', compact('unitevaleurs','uniteValeursAll', 'niveaux', 'filieres', 'total'));
    }

    public function create()
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        return view('unitevaleur.create', compact('niveaux', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        UniteValeur::create($request->all());

        return redirect()->route('uniteValeur.index')->with('success', 'Unité de valeur créée avec succès.');
    }

    public function show(UniteValeur $uniteValeur)
    {
        return view('unitevaleur.show', compact('uniteValeur'));
    }

    public function edit(UniteValeur $uniteValeur)
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        return view('unitevaleur.edit', compact('uniteValeur', 'niveaux', 'filieres'));
    }

    public function update(Request $request, UniteValeur $unitevaleur)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $unitevaleur->update($request->all());

        return redirect()->route('uniteValeur.index')->with('success', 'Unité de valeur mise à jour avec succès.');
    }

    public function destroy(UniteValeur $uniteValeur)
    {
        $uniteValeur->delete();

        return redirect()->route('uniteValeur.index')->with('success', 'Unité de valeur supprimée avec succès.');
    }
}
