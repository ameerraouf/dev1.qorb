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
        Schema::table('childrens', function (Blueprint $table) {
            $table->tinyInteger('early_detection_report_status')->default(0);//1 for converted // 0 for Not Converted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('childrens', function (Blueprint $table) {
            //
        });
    }
};
