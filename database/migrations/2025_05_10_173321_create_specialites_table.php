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
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->foreignId("filiere_id")->nullable()->constrained('filieres')->onDelete('set null');
            $table->foreignId("specialite_concour_id")->nullable()->constrained('specialite_concours')->onDelete('set null');
            $table->string('name_fr');
            $table->string('name_ar')->nullable();
            $table->string('description')->nullable();
            $table->decimal('coefficient')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialites');
    }
};
