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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->string('order_number', 50);
            $table->decimal('sub_total')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('shipping_cost')->default(0.00);
            $table->decimal('tax')->default(0.00);
            $table->decimal('platform_charge')->default(0.00);
            $table->decimal('grand_total')->default(0.00);
            $table->string('payment_method', 100)->nullable();
            $table->string('payment_status', 15)->default('due')->comment('paid, due, free, pending, cancelled');
            $table->tinyInteger('delivery_status')->default(0)->comment('0=pending, 1=complete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
