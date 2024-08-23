<?php

namespace App\Models;

use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{

    protected $with= [
        'filieres',
        ];

    public function filieres():HasMany
    {
        return $this->hasMany(Filiere::class);
     }
    use HasFactory;
}
