<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecialiteConcours>
 */
class SpecialiteConcourFactory extends Factory
{
    protected $model = \App\Models\SpecialiteConcour::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('???-####')),
            'name_fr' => $this->faker->word(),
            'name_ar' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
