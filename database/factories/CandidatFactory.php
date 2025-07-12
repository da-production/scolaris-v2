<?php

namespace Database\Factories;

use App\Models\Candidat;
use App\Models\Wilaya;  // Assuming you have a Wilaya model
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public function definition()
    {
        return [
            // Bac Information
            'numero_bac' => $this->faker->unique()->bothify('#####??#####'),
            'annee_bac' => $this->faker->year(),
            'exercice' => $this->faker->date(),
            
            // Email
            'email' => $this->faker->unique()->safeEmail(),
            
            // National ID (NIN)
            'nin' => $this->faker->optional()->bothify('################'),
            
            // Name and Arabic Name
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'nom_ar' => $this->faker->lastName(),
            'prenom_ar' => $this->faker->firstName(),
            
            // Password (hashed)
            'password' => bcrypt('password'),  // Default password

            // Gender (Optional)
            'genre' => $this->faker->randomElement(['Masculin', 'Féminin']),

            // Phone numbers (Optional)
            'mobile_1' => $this->faker->phoneNumber(),
            'mobile_2' => $this->faker->optional()->phoneNumber(),
            'fix' => $this->faker->optional()->phoneNumber(),

            // Date of Birth and Birthplace
            'date_naissance' => $this->faker->optional()->date(),
            'lieu_naissance' => $this->faker->city(),
            
            // Address and Profile Picture
            'adresse' => $this->faker->address(),
            'profile_picture' => $this->faker->optional()->imageUrl(),

            // Candidat State
            'etat' => $this->faker->randomElement([0, 1]),  // 0 or 1 for state
            
            // Wilaya (assuming foreign key to wilayas table)
            'wilaya_id' => Wilaya::inRandomOrder()->pluck('id')->first(),  // Automatically create a Wilaya for the foreign key

            // Validation Status
            'valide' => $this->faker->boolean(50),  // 50% chance of being true

            // Timestamps
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
