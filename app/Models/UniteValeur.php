<?php

namespace App\Models;

use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniteValeur extends Model
{
    use HasFactory;


    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class, 'foreign_key', 'other_key');
    }

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'foreign_key', 'other_key');
    }
}
