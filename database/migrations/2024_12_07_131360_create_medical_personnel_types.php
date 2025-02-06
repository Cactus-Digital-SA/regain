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
            $table->bigInteger('type_id')->unsigned()->primary();
            $table->string('label', 512);
        });

        Schema::create('medical_types', function (Blueprint $table) {
            $table->bigInteger('type_id')->unsigned()->primary();
            $table->foreignId('category_type_id')->references('type_id')->on('medical_type_categories')->cascadeOnDelete();
            $table->string('label', 512);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_types');
        Schema::dropIfExists('medical_type_categories');
    }
};
