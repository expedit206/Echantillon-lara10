<?php

namespace App\Models;

use App\Models\Filiere;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialite extends Model
{
    use HasFactory;
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function uniteValeurs():HasMany
    {
        return $this->hasMany(UniteValeur::class);
     }

}
