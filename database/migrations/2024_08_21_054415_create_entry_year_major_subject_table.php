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
        Schema::create('entry_year_major_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->foreignId('entry_year_id');
            $table->foreignId('major_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_year_major_subject');
    }
};
