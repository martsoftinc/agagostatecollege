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
    Schema::create('assessment_weights', function (Blueprint $table) {
        $table->id();
        $table->foreignId('academic_year_id')->nullable()->constrained()->nullOnDelete();
        $table->decimal('midsem_percent', 5, 2)->default(40.00);
        $table->decimal('exam_percent', 5, 2)->default(60.00);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_weights');
    }
};
