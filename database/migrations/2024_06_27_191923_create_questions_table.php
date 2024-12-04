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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            //Relations
            $table->foreignId('instruction_id')->nullable('instructions')->constrained()->nullOnDelete();
            $table->foreignId('subscale_id')->nullable()->constrained('subscales')->nullOnDelete();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            //Sorting
            $table->unsignedInteger('sort')->nullable();
            $table->boolean('select_multiple')->nullable();
            $table->unsignedInteger('max_selections')->nullable();

            //Status
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('language_question', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_response', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('response_id')->constrained('responses')->cascadeOnDelete();
            $table->string('score')->nullable();
            $table->timestamps();
        });

        Schema::create('question_required_response', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('question_response_id')->constrained('question_response')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('question_reference', function (Blueprint $table) {
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
        Schema::dropIfExists('language_question');
        Schema::dropIfExists('question_response');
        Schema::dropIfExists('question_required_response');
        Schema::dropIfExists('question_reference');
    }
};
