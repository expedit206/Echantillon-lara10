<?php

namespace App\Models;

use App\Models\Filiere;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialite extends Model
{
    use HasFactory;

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    // public function uniteValeurs():HasMany
    // {
    //     return $this->hasMany(UniteValeur::class);
    //  }

     public function uniteValeurs()
     {
         return $this->belongsToMany(UniteValeur::class, 'specialite_unite_de_valeur', 'specialite_id', 'unite_de_valeur_id');
     }
     /**
      * The enseignants that belong to the Specialite
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
      */
     public function enseignants(): BelongsToMany
     {
         return $this->belongsToMany(Enseignant::class);
     }
}
