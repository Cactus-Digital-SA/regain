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
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('region_id')->references('id')->on('regions')->cascadeOnDelete();
            $table->foreignId('medical_type_category_id')->references('type_id')->on('medical_type_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
