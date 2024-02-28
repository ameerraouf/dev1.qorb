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
        Schema::create('society_replies', function (Blueprint $table) {
            $table->id();
            $table->string('reply')->nullable();
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('teacher_id');

            $table->foreign('society_id')->references('id')->on('societies');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_replies');
    }
};
