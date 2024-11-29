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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->smallInteger('type');

            //Sorting
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('responses_languages', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->foreignId('response_id')->constrained('responses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
        Schema::dropIfExists('responses_languages');
    }
};
