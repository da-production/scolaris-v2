<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Domain;
use App\Models\Filiere;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Domain::factory(10)->create();  // Creates 10 domains
        // Filiere::factory(30)->create();  // Creates 10 filieres
        // SpecialiteConcour::factory(5)->create();  // Creates 10 specialite concours
        // Specialite::factory(80)->create();  // Creates 10 specialites
        // Candidat::factory(50)->create();
        Candidature::factory(50)->create();
    }
}
