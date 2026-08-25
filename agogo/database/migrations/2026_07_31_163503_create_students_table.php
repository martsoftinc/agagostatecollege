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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // System & Academic Identifiers
            $table->string('index_number')->unique()->comment('Agogo State College Index No.');
            $table->string('pin', 10)->nullable()->comment('Portal access PIN (Defaults to Year of Birth)');
            $table->string('course')->comment('e.g. General Science, Business, General Arts');
            $table->string('class')->comment('e.g. Form 1 Sci 1, Form 2 Arts 2');
            $table->enum('track', ['Green', 'Gold', 'Single Track'])->default('Green')->comment('GES Double Track assignment');
            $table->string('house')->nullable()->comment('e.g. House 1 - Owusu Ansah, House 2');

            // Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth');
            $table->string('place_of_residence')->nullable()->comment('Hometown / Current Community');
            $table->text('address')->nullable()->comment('Residential / Postal Address');

            // Parent / Guardian Information
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->string('guardian_occupation')->nullable();

            // Previous School History (JHS)
            $table->string('jhs_previous_school')->nullable();
            $table->string('jhs_index_number')->nullable()->comment('BECE Index Number');
            $table->string('jhs_position_held')->nullable()->comment('e.g. Prefect, Class Rep');

            // Health & Extracurriculars
            $table->text('interests_hobbies')->nullable();
            $table->text('medical_conditions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};