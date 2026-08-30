<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exeats', function (Blueprint $table) {
            $table->id();

            // Who is going out
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            // Exeat details
            $table->string('type')->default('day'); // day, weekend, emergency, medical, other
            $table->string('destination');
            $table->text('reason');

            // Timing
            $table->dateTime('departure_at');
            $table->dateTime('expected_return_at');
            $table->dateTime('actual_return_at')->nullable();

            // Status tracking
            $table->string('status')->default('pending');
            // pending, approved, rejected, out, returned, overdue, cancelled

            // Who logged / approved it
            $table->foreignId('logged_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            // Optional extra info
            $table->string('guardian_contact')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Helpful indexes
            $table->index(['student_id', 'status']);
            $table->index('departure_at');
            $table->index('expected_return_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exeats');
    }
};