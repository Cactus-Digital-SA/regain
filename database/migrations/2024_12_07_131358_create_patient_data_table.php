<?php

use App\Domains\Patient\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('birthday')->nullable();
            $table->bigInteger('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('post_code')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->boolean('accessible_mobility')->default(false);
            $table->text('notes')->nullable();
            $table->enum('status', StatusEnum::values());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_data');
    }
};
