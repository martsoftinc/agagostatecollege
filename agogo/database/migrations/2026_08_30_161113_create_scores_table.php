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
    Schema::create('scores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
        $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
        $table->foreignId('class_stream_id')->constrained()->cascadeOnDelete();

        // Raw scores (out of 100)
        $table->decimal('classwork_score', 5, 2)->nullable();
        $table->decimal('midsem_score', 5, 2)->nullable();
        $table->decimal('exam_score', 5, 2)->nullable();

        // Calculated fields
        $table->decimal('total_score', 5, 2)->nullable();      // weighted total
        $table->string('grade', 5)->nullable();                // A1, B2, B3...
        $table->decimal('grade_point', 3, 1)->nullable();      // 4.0, 3.5...

        // Optional
        $table->unsignedSmallInteger('attendance')->nullable(); // days present
        $table->text('teacher_comment')->nullable();

        $table->boolean('is_submitted')->default(false);
        $table->timestamps();

        // Prevent duplicate entry
        $table->unique(['student_id', 'subject_id', 'semester_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
