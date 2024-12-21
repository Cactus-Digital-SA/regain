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
        Schema::create('report_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practitioner_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('patient_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('test_id')->references('id')->on('tests')->cascadeOnDelete();
            $table->string('uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_files');
    }
};
