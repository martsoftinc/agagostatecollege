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
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('original_name');
        $table->string('file_path');
        $table->string('mime_type');
        $table->string('extension', 20);
        $table->unsignedBigInteger('file_size');
        $table->string('disk')->default('public');
        $table->enum('visibility', ['private', 'public'])->default('private');
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
