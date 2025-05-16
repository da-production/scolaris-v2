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
        Schema::create('sous_specialites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name_fr');
            $table->string('name_ar')->nullable();
            $table->decimal('ponderation')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_specialites');
    }
};
