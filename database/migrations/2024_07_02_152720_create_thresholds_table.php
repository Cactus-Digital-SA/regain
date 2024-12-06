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
        Schema::create('thresholds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('subscale_id')->nullable()->constrained('subscales')->nullOnDelete();
            $table->foreignId('question_start')->nullable()->constrained('questions')->nullOnDelete();
            $table->foreignId('question_end')->nullable()->constrained('questions')->nullOnDelete();
            $table->smallInteger('display_type');
            $table->timestamps();
        });

        Schema::create('thresholds_subscale_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('threshold_id')->constrained('thresholds')->cascadeOnDelete();
            $table->integer('low');
            $table->integer('high');
            $table->string('label');
            $table->string('notes');
            $table->timestamps();
        });

        Schema::create('thresholds_test_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('threshold_id')->constrained('thresholds')->cascadeOnDelete();
            $table->integer('low');
            $table->integer('high');
            $table->string('label');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thresholds');
        Schema::dropIfExists('thresholds_subscale_limits');
        Schema::dropIfExists('thresholds_test_limits');
    }
};
