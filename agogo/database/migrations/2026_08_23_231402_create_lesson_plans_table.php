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
        // 1. Core Lesson Plans Table
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();

            // Foreign Key - Author / Teacher
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Basic Information
            $table->string('school_name')->nullable();
            $table->string('subject');
            $table->string('class_form'); // e.g., SHS 1, SHS 2
            $table->date('lesson_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration_minutes')->default(80);
            $table->integer('class_size')->nullable();
            $table->string('unit_topic');
            $table->string('sub_topic')->nullable();

            // Curriculum & Instructional Objectives
            $table->text('content_standard')->nullable();
            $table->string('indicator_code_or_text')->nullable();
            $table->json('performance_indicators'); // Array of objectives (cognitive, psychomotor, affective)
            $table->json('core_competencies')->nullable(); // Array of target NaCCA competencies
            $table->json('key_vocabulary')->nullable();
            $table->text('teaching_learning_resources')->nullable(); // TLMs (free-text notes)

            // Phased Instructional Delivery
            $table->json('phase_1_introduction'); // { duration: 10, teacher_activity: "", student_activity: "", assessment: "" }
            $table->json('phase_2_main_body');     // Array of structured steps
            $table->json('phase_3_closure');       // { duration: 10, teacher_activity: "", student_activity: "", assessment: "" }

            // Assessment & Post-Lesson Reflection
            $table->text('evaluative_exercise')->nullable();
            $table->text('reflection_strengths')->nullable();
            $table->text('reflection_weaknesses')->nullable();
            $table->text('reflection_remedial_action')->nullable();

            // Visibility & Access Control
            $table->enum('visibility', ['private', 'public'])->default('private');

            $table->timestamps();
            $table->softDeletes();

            // Performance Indexes
            $table->index(['user_id', 'visibility']);
            $table->index(['subject', 'class_form']);
        });

        // 2. Specific Sharing Pivot Table
        Schema::create('lesson_plan_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Recipient

            $table->enum('permission', ['view', 'edit'])->default('view');

            $table->timestamps();

            $table->unique(['lesson_plan_id', 'user_id']);
        });

        // 3. External Resources (YouTube, Google Drive, websites, etc.)
        Schema::create('lesson_plan_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_plan_id')->constrained()->cascadeOnDelete();

            $table->string('title');                       // e.g. "Photosynthesis Explained"
            $table->string('url');                         // full link
            $table->enum('type', [                         // helps with icons / filtering
                'youtube',
                'google_drive',
                'website',
                'document',
                'other'
            ])->default('other');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0); // for ordering

            $table->timestamps();

            $table->index(['lesson_plan_id', 'sort_order']);
        });

        // 4. File Attachments (PDF + Images only)
        Schema::create('lesson_plan_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_plan_id')->constrained()->cascadeOnDelete();

            $table->string('original_name');               // original filename from user
            $table->string('file_path');                   // storage path (e.g. lesson-plans/attachments/...)
            $table->string('mime_type');                   // application/pdf, image/jpeg, image/png, etc.
            $table->string('extension', 10);               // pdf, jpg, png, webp...
            $table->unsignedBigInteger('file_size');       // in bytes
            $table->string('disk')->default('public');     // storage disk
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['lesson_plan_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plan_attachments');
        Schema::dropIfExists('lesson_plan_resources');
        Schema::dropIfExists('lesson_plan_shares');
        Schema::dropIfExists('lesson_plans');
    }
};