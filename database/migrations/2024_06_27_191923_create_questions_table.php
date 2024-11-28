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
            $table->string('title');

            //Relations
            $table->foreignId('instruction_id')->nullable('instructions')->constrained()->nullOnDelete();
            $table->foreignId('subscale_id')->nullable()->constrained('subscales')->nullOnDelete();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();

            //Sorting
            $table->unsignedInteger('sort')->nullable();

            //Status
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('question_languages', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_available_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('response_id')->constrained('responses_pool')->cascadeOnDelete();
            $table->string('score')->nullable();
            $table->timestamps();
        });

        //What response is required for this question
        Schema::create('question_required_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('response_id')->constrained('responses_pool')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('reference_id')->constrained('references')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_languages');
        Schema::dropIfExists('question_available_responses');
        Schema::dropIfExists('question_required_responses');
        Schema::dropIfExists('question_references');
    }
};
