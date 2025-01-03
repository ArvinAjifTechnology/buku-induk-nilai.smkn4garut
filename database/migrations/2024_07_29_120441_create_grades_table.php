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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('uniqid')->unique();
            $table->foreignId('student_id');
            $table->foreignId('subject_id');
            $table->foreignId('semester_id');
            $table->integer('score');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
