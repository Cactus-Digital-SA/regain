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
        Schema::create('user_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedSmallInteger('questionnaire_flow_type');
            $table->foreign('questionnaire_flow_type')->references('flow_type')->on('questionnaire_flows')->onDelete('cascade');
            $table->foreignId('for_user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->text('generated_questions');
            $table->boolean('completed')->default(false);
            $table->unique(['user_id', 'questionnaire_flow_type', 'for_user_id'], "unique_user_questionnaire_flow");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_questionnaires');
    }
};
