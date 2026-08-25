<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->json('target_roles')->nullable();      // ['student', 'teacher']
            $table->json('target_classes')->nullable();    // ['SH1', 'SH2', 'SH3']
            $table->json('target_programmes')->nullable(); // ['General Science', ...]
            $table->boolean('send_sms')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};