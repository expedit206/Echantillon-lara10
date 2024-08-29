<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EtudiantUniteValeurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etudiant_id' => Etudiant::inRandomOrder()->first()->id, // Sélectionne un étudiant au hasard
            'unite_valeur_id' => UniteValeur::inRandomOrder()->first()->id, // Sélectionne une unité de valeur au hasard
        ];
    }
}
