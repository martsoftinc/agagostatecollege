<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pta_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('meeting_date');
            $table->time('meeting_time');
            $table->string('venue');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pta_meetings');
    }
};