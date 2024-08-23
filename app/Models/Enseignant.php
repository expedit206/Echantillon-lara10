<?php

namespace App\Models;

use App\Models\Niveau;
use App\Models\Filiere;

use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    // 'niveaux',
    // 'filieres',
    // 'uniteValeurs'
    ];




    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'enseignant_filiere', 'enseignant_id', 'filiere_id');
    }

    public function uniteValeurs(): HasMany
    {
        return $this->hasMany(UniteValeur::class);
    }


    public function niveaux(): BelongsToMany
    {
        return $this->belongsToMany(Niveau::class);
    }



}
