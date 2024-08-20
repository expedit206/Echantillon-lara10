<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    use HasFactory;

    protected $casts = [
        'dateNaissance' => 'datetime',
        'lieuNaissance' => 'datetime',
        'email_verified_at' => 'datetime',

        // Ajoutez les autres champs qui doivent être des dates
    ];
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'dateNaissance',
        'lieuNaiss',
        'telephone',
        'idFiliere',
        'idNiveau',
        'sexe',
        'code',
        'photo',
        'annee_id'
    ];

    protected $with=[
        'niveau',
        'filiere',
        'niveau',
        'annee'

    ];
    protected $hidden = [
        'code'
    ];

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'idFiliere', 'id');
    }


    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class, 'idNiveau', 'id');
    }


    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

}
