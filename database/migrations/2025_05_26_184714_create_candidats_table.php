<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('numero_bac');
            $table->string('annee_bac');
            $table->date('exercice');
            $table->string('email');
            $table->string('nin',18)->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nom_ar')->nullable();
            $table->string('prenom_ar')->nullable();
            $table->string('password');
            $table->string('genre')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('fix')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->text('profile_picture')->nullable();
            $table->integer('etat')->nullable();
            $table->foreignId('wilaya_id')->nullable()->constrained('wilayas')->onDelete('set null');
            $table->boolean('valide')->default(false);
            $table->timestamps();

            $table->unique(['numero_bac', 'annee_bac', 'email','exercice'], 'unique_candidat_authentication');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
