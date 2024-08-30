<?php

namespace App\Models;

use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['nom'];

    // Si vous avez des relations, vous pouvez les définir ici
    public function matieres()
    {
        return $this->hasMany(UniteValeur::class); // Adaptez cette relation en fonction de votre modèle Matiere
    }
}
