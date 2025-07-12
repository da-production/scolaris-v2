<?php

namespace Database\Factories;

use App\Models\Candidat;
use App\Models\Classification;
use App\Models\Domain;
use App\Models\Filiere;
use App\Models\Motif;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidature>
 */
class CandidatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'candidat_id' => Candidat::factory(),  // Create a fake Candidat
            'domain_id' => Domain::inRandomOrder()->first()->id,  // Random domain (nullable)
            'filiere_id' => Filiere::inRandomOrder()->first()->id,  // Random filiere (nullable)
            'specialite_id' => Specialite::inRandomOrder()->first()->id,  // Random specialite
            'specialite_concour_id' => SpecialiteConcour::inRandomOrder()->first()->id,  // Random specialite concours
            'classification_id' => Classification::inRandomOrder()->first()->id,  // Random classification
            'motif_id' => Motif::inRandomOrder()->first()->id,  // Random motif (nullable)
            'commentaire' => $this->faker->paragraph(),
            'moyenne_semestres' => $this->faker->randomFloat(2, 0, 20),  // Random average between 0 and 20
            'moyenne' => $this->faker->randomFloat(2, 0, 20),  // Random average between 0 and 20
            'decision' => $this->faker->randomElement(['EN_ATTENTE', 'ACCEPTE', 'REFUSE']),  // Random decision
            'exercice' => $this->faker->year(),
            'numero_bac' => $this->faker->unique()->numerify('BAC######'),  // Random unique BAC number
            'annnee_bac' => $this->faker->year(),
            'moyenne_bac' => $this->faker->randomFloat(2, 0, 20),  // Random BAC average
            'type_diplome' => $this->faker->word(),  // Random type of diploma
            'annee_diplome' => $this->faker->year(),
            'etablissement_diplome' => $this->faker->company(),  // Random diploma establishment
        ];
    }
}
