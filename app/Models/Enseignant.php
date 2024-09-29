<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;

use App\Models\Specialite;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Enseignant extends Authenticatable
{
    use HasFactory;


    protected $casts = [
        'dateNaiss' => 'datetime',
        'debutContrat' => 'datetime',
        'finContrat' => 'datetime',
        'email_verified_at' => 'datetime',

        // Ajoutez les autres champs qui doivent être des dates
    ];
    protected $fillable = [
        'nom',
        'prenom',
        'uniteValeur',
        'email',
        'password',
        'prenom',
         'photo',
        'sexe',
        'dateNaiss',
        'lieuNaiss',
        'annee_id',
        'nationalite',
        'mobile',
        'profession',
        'diplome',
        'salaire',
        'typeContrat',
        'debutContrat',
        'finContrat',
        'email',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $with= [
    'niveaux',
    'filieres',
    'uniteValeurs',
    'specialites'
    ];




    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'enseignant_filiere', 'enseignant_id', 'filiere_id');
    }


    public function uniteValeurs(): BelongsToMany
    {
        return $this->belongsToMany(UniteValeur::class, 'enseignant_unite_valeur');
    }

    public function specialites(): BelongsToMany
    {
        return $this->belongsToMany(Specialite::class);
    }


    public function niveaux(): BelongsToMany
    {
        return $this->belongsToMany(Niveau::class);
    }


public function annee(): BelongsTo
{
    return $this->belongsTo(Annee::class);
}

}
