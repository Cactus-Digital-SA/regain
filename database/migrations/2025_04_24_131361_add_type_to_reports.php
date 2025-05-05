<?php

use App\Domains\Reports\Constants\ReportTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_files', static function (Blueprint $table) {
            $table->smallInteger('report_type')->default(ReportTypes::TEST);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
