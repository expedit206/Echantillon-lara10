<?php

namespace App\Models;

use App\Models\Niveau;
use App\Models\Filiere;

use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'uniteValeur',
        'email',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];




    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'role_user_table', 'user_id', 'role_id');
    }

    public function uniteValeurs(): HasMany
    {
        return $this->hasMany(UniteValeur::class, 'foreign_key', 'local_key');
    }


    public function niveaux(): BelongsToMany
    {
        return $this->belongsToMany(Niveau::class, 'role_user_table', 'user_id', 'role_id');
    }



}
