<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\SpecialiteConcour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialite>
 */
class SpecialiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filiere_id' => Filiere::factory(),  // Automatically create a related Filiere
            'specialite_concour_id' => SpecialiteConcour::factory(),  // Automatically create a related SpecialiteConcours
            'name_fr' => $this->faker->word(),
            'name_ar' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'coefficient' => $this->faker->randomFloat(1, 1, 5),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
