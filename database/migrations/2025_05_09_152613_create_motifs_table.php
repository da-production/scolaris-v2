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
        Schema::create('motifs', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr');
            $table->string('name_ar')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motifs');
    }
};
