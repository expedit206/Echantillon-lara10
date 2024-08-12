<?php

namespace App\Models;

use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'dateNaissance',
        'telephone',
        'idFiliere',
        'idNiveau',
        'sexe',
        'code'
    ];


    protected $hidden = [
        'code'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'foreign_key', 'other_key');
    }


    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class, 'foreign_key', 'other_key');
    }
}
