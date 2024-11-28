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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('name');

            //Sorting
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('subscales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->text('name');
            // this will be a number that when added we will randomly show this number from the available questions
            $table->unsignedSmallInteger('pick_upto_questions')->default(0);
            $table->boolean('calculate_score')->default(true);

            //Sorting
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
        Schema::dropIfExists('subscales');
    }
};
