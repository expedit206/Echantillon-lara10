<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Enseignant;
use App\Models\Specialite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniteValeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'credit',
        'code',
        'enseignant_id',
        'filiere_id',
        'specialite_id',
        'niveau_id',
    ];
    protected $table = 'unite_de_valeurs';

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class);
    }

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }


    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
