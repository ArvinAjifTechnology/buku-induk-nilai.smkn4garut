<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('uniqid')->unique();
            $table->foreignId('school_class_id');
            $table->foreignId('major_id')->nullable();
            $table->foreignId('entry_year_id');
            $table->foreignId('graduation_year_id')->nullable();
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']);
            $table->string('nisn')->unique();
            $table->string('nik')->unique();
            $table->string('nis')->unique();
            $table->enum('student_statuses', ['active', 'graduated', 'dropped_out'])->default('active');
            $table->string('photo')->nullable();
            $table->string('birth_date');
            $table->string('birth_place');
            // $table->string('specialization');
            $table->string('religion');
            $table->string('nationality');
            $table->boolean('special_needs')->default(false);
            $table->string('address');
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village');
            $table->string('district');
            $table->string('postal_code')->nullable();
            $table->string('residence');
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('siblings')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('father_name')->nullable();
            $table->integer('father_birth_year')->nullable();
            $table->string('father_education')->nullable();
            $table->string('father_job')->nullable();
            $table->string('father_nik')->nullable();
            $table->boolean('father_special_needs')->default(false);
            $table->string('mother_name')->nullable();
            $table->integer('mother_birth_year')->nullable();
            $table->string('mother_education')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('mother_nik')->nullable();
            $table->boolean('mother_special_needs')->default(false);
            $table->string('guardian_name')->nullable();
            $table->integer('guardian_birth_year')->nullable();
            $table->string('guardian_education')->nullable();
            $table->string('guardian_job')->nullable();
            $table->string('exam_number')->nullable();
            $table->string('smp_certificate_number')->nullable();
            $table->string('smp_skhun_number')->nullable();
            $table->string('school_origin')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('smk_certificate_number')->nullable();
            $table->string('smk_skhun_number')->nullable();
            $table->date('exit_date')->nullable();
            $table->string('exit_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
