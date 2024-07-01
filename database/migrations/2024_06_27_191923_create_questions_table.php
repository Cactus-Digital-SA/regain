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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instruction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subscale_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('test_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_response', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('response_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_reference', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reference_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('language_question', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('response_question');
        Schema::dropIfExists('reference_question');
    }
};
