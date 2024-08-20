<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annee extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'debut', 'fin', 'is_active'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function cours()
    {
        return $this->hasMany(UniteValeur::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}
