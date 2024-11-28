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
        Schema::create('responses_pool', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->smallInteger('type');

            //Sorting
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('responses_pool_languages', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->foreignId('response_pool_id')->constrained('responses_pool')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses_pool');
        Schema::dropIfExists('responses_pool_languages');
    }
};
