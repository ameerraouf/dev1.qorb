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
        Schema::table('purchase_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_service_id')->nullable()->change();
            $table->tinyInteger('package_status')->after('sub_service_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_transactions', function (Blueprint $table) {
            //
        });
    }
};
