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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained('candidatures')->onDelete('cascade');
            $table->string('type'); // Type of document (e.g., 'Bac', 'Diploma', 'Identity', etc.)
            $table->string('file_path'); // Path to the stored document file
            $table->string('file_name'); // Original name of the uploaded file
            $table->string('file_extension'); // File extension (e.g., 'pdf', 'jpg', 'png', etc.)
            $table->string('file_size'); // Size of the file in bytes
            $table->text('comments')->nullable(); // Additional comments or notes about the document
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
