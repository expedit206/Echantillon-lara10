<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semestre extends Model
{
    use HasFactory;
    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
    public function uniteValeurs(): HasMany
    {
        return $this->hasMany(UniteValeur::class);
    }

}
