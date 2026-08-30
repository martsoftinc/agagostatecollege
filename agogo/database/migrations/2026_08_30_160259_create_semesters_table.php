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
    Schema::create('semesters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
        $table->string('name');                     // Semester 1, Semester 2
        $table->unsignedTinyInteger('number');      // 1 or 2
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->boolean('is_current')->default(false);
        $table->boolean('is_locked')->default(false); // prevent editing after publishing
        $table->timestamps();

        $table->unique(['academic_year_id', 'number']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
