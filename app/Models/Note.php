<?php

namespace App\Models;

use App\Models\Etudiant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
protected $fillable=[
    'etudiant_id',
    'unite_valeur_id',
    'note',
    'type',
    'enseignant_id'
];
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }



    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    public function uniteValeur()
    {
        return $this->belongsTo(UniteValeur::class);
    }
    public function semestre()
{
    return $this->uniteValeur->semestre;
}
}
