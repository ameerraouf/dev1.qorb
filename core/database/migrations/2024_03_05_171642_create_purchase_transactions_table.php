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
        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('children_ids');
            $table->unsignedBigInteger('main_service_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->decimal('price', 10, 2); // assuming you want a decimal number with precision of 10 digits and 2 decimal places
            $table->timestamps();
            $table->foreign('main_service_id')->references('id')->on('main_services');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('sub_service_id')->references('id')->on('sub_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_transactions');
    }
};