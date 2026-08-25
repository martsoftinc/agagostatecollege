<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            
            // Passport picture
            $table->string('passport_picture')->nullable();

            // Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('gender');
            $table->string('role')->default('student');
            $table->date('date_of_birth');
            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->default('Ghanaian');
            $table->string('religion')->nullable();
            $table->string('home_town')->nullable();
            
            // Parent / Guardian
            $table->string('parent_guardian_name');
            $table->string('parent_guardian_phone');
            $table->string('parent_guardian_email')->nullable();
            $table->string('relationship'); // father, mother, guardian, other
            $table->string('parent_guardian_occupation');
            $table->text('address');
            $table->string('place_of_residence');

            // Previous School Information
            $table->string('previous_school');
            $table->string('index_number');
            $table->string('bece_year')->nullable();
            $table->string('programme');
            $table->string('position_held')->nullable();

            // Additional Information
            $table->text('interests_hobbies')->nullable();
            $table->text('medical_conditions')->nullable();

            // Payment Information
            $table->decimal('amount_paid', 10, 2)->default(30.00);
            $table->string('payment_reference')->unique()->nullable();
            $table->string('payment_status')->default('pending'); // pending, paid, failed

            // Status
            $table->string('status')->default('pending'); // pending, reviewed, accepted, rejected

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
};