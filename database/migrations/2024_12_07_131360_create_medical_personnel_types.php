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
        Schema::create('medical_type_categories', function (Blueprint $table) {
            $table->id();
            $table->string('value', 255)->unsigned();
            $table->timestamps();
        });

        Schema::create('medical_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_type')->references('id')->on('practitioners')->cascadeOnDelete();
            $table->string('value', 255)->unsigned();
            $table->timestamps();
        });

        Schema::create('practitioner_medical_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practitioner_id')->references('id')->on('practitioners')->cascadeOnDelete();
            $table->foreignId('medical_type')->references('id')->on('medical_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioner_medical_types');
        Schema::dropIfExists('medical_types');
        Schema::dropIfExists('medical_type_categories');
    }
};
