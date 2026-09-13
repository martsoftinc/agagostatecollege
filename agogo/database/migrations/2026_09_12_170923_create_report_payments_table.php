<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->unique();          // Paystack reference
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('GHS');
            $table->string('status')->default('pending');  // pending, success, failed
            $table->string('channel')->nullable();         // card, mobile_money, etc.
            $table->json('paystack_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'semester_id']); // one payment per student per semester
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_payments');
    }
};