<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_fr' => $this->faker->word(),
            'name_ar' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
