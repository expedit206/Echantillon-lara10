<?php
namespace App\Models;

use App\Models\Niveau;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;

    protected $with= [
        // 'students',
        // 'uniteValeurs',
        // 'niveau',
        // 'enseignants'
        ];

    public function students(): HasMany
    {
        return $this->hasMany(Etudiant::class);
    }

    public function uniteValeurs(): HasMany
    {
        return $this->hasMany(UniteValeur::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'enseignant_filiere', 'filiere_id', 'enseignant_id');
    }
}
