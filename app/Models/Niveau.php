<?php

namespace App\Models;

use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Niveau extends Model
{

    protected $with= [
        'filieres',
        ];

    public function filieres():HasMany
    {
        return $this->hasMany(Filiere::class);
     }



    public function uniteValeurs():HasMany
    {
        return $this->hasMany(UniteValeur::class);
     }

     public function enseignants(): BelongsToMany
     {
         return $this->belongsToMany(Enseignant::class);
     }
    use HasFactory;
}
