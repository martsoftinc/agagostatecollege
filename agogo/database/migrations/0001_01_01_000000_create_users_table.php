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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Personal information
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();;
            $table->string('last_name')->nullable();;
            $table->string('other_names')->nullable();
          
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
           
            // Contact details
            $table->string('phone', 20)->unique()->nullable();;
            $table->boolean('is_active')->default(true)->nullable();;
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            // Email verification code
            $table->string('email_verification_code', 6)->nullable();
            $table->timestamp('email_verification_sent_at')->nullable();

            $table->string('student_id')->nullable()->unique()->comment('Agogo State College Index No.');
            $table->string('pincode', 255)->nullable()->comment('Portal access PIN (Defaults to Year of Birth)');
            $table->string('programme')->nullable()->comment('e.g. General Science, Business, General Arts');
            $table->string('class')->nullable()->comment('e.g. Form 1 Sci 1, Form 2 Arts 2');
            $table->enum('track', ['Green', 'Gold', 'Single Track'])->default('Green')->nullable()->comment('GES Double Track assignment');
            $table->string('house')->nullable()->comment('e.g. House 1 - Owusu Ansah, House 2');
            $table->string('boarding')->nullable();
            // Personal Information
            
            
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_residence')->nullable()->comment('Hometown / Current Community');
            $table->text('address')->nullable()->comment('Residential / Postal Address');

            // Parent / Guardian Information
            $table->string('guardian_name')->nullable();;
            $table->string('guardian_phone')->nullable();;
            $table->string('guardian_occupation')->nullable();

            // Previous School History (JHS)
            $table->string('jhs_previous_school')->nullable();
            $table->string('jhs_index_number')->nullable()->comment('BECE Index Number');
            $table->string('jhs_position_held')->nullable()->comment('e.g. Prefect, Class Rep');

            // Health & Extracurriculars
            $table->text('interests_hobbies')->nullable();
            $table->text('medical_conditions')->nullable();

 
            // Security
            $table->string('password')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_code', 6)->nullable();
            $table->timestamp('two_factor_sent_at')->nullable();


            // Techears only
            $table->string('staff_id')->nullable();
            $table->string('rank')->nullable();

            $table->rememberToken();
 
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
