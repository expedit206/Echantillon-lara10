<?php

namespace App\Models;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;


    public function students(): HasMany
    {
        return $this->hasMany(Etudiant::class, 'foreign_key', 'local_key');
    }

    public function uniteValeurs(): HasMany
    {
        return $this->hasMany(uniteValeurs::class, 'foreign_key', 'local_key');
    }
}
