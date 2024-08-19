<?php

namespace Database\Factories;

use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Récupérer un nom d'unité de valeur aléatoire pour la clé étrangère
        $uniteValeur = UniteValeur::inRandomOrder()->first();

        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(['Masculin', 'Féminin', 'Autre']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Vous pouvez utiliser Hash::make('password') aussi
            'uniteValeur' => $uniteValeur ? $uniteValeur->nom : 'Inconnu',
            'dateNaiss' => $this->faker->date(),
            'lieuNaiss' => $this->faker->city,
            'nationalite' => $this->faker->country,
            'mobile' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(),
            'profession' => $this->faker->jobTitle,
            'diplome' => $this->faker->word,
            'salaire' => $this->faker->randomFloat(2, 2000, 10000),
            'typeContrat' => $this->faker->randomElement(['CDI', 'CDD', 'Intérim', 'Stage', 'Autre']),
            'debutContrat' => $this->faker->date(),
            'finContrat' => $this->faker->optional()->date(),
        ];
    }
}
