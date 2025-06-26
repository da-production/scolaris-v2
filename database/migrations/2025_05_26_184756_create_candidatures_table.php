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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
            $table->foreignId('domain_id')->nullable()->constrained('domains')->onDelete('cascade')->onDelete('set null');
            $table->foreignId('filiere_id')->nullable()->constrained('filieres')->onDelete('cascade')->onDelete('set null');
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->foreignId('specialite_concour_id')->constrained('specialite_concours')->onDelete('cascade');
            $table->foreignId('classification_id')->constrained('classifications')->onDelete('cascade');
            $table->decimal('moyenne', 5, 2)->default(0);
            $table->string('decision')->default('EN_ATTENTE');
            $table->text('commentaire')->nullable();
            $table->string('exercice')->nullable();
            $table->string('numero_bac')->nullable();
            $table->date('annnee_bac')->nullable();
            $table->decimal('moyenne_bac')->nullable();
            $table->string('type_diplome')->nullable();
            $table->date('annee_diplome')->nullable();
            $table->string('etablissement_diplome')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
