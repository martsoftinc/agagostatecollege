<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. SHS 1, SHS 2, SHS 3
            $table->string('code')->unique(); // e.g. SHS1, SHS2
            $table->integer('level_order')->default(1); // 1 for SHS1, 2 for SHS2, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};