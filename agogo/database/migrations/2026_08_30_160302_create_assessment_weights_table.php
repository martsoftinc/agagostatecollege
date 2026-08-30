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
        $table->decimal('classwork_percent', 5, 2)->default(25.00);  // e.g. 25%
        $table->decimal('midsem_percent', 5, 2)->default(25.00);
        $table->decimal('exam_percent', 5, 2)->default(50.00);
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
