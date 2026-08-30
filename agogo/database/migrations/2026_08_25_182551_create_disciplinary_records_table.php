<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disciplinary_records', function (Blueprint $table) {
            $table->id();

            // Who was involved
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            // Incident details
            $table->date('incident_date');
            $table->string('category'); // lateness, fighting, insolence, vandalism, uniform, theft, bullying, other
            $table->string('severity')->default('minor'); // minor, major, serious
            $table->text('description');

            // Action & points
            $table->string('action_taken')->nullable(); // warning, detention, suspension, counselling, fine, parents_called, other
            $table->unsignedInteger('demerit_points')->default(0);

            // Status
            $table->string('status')->default('open'); // open, under_review, resolved

            // Who logged it
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();

            // Extra
            $table->text('notes')->nullable();
            $table->dateTime('resolved_at')->nullable();

            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index('incident_date');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplinary_records');
    }
};