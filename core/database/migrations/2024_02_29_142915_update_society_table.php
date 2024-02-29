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
        Schema::table('societies', function (Blueprint $table) {
            // $table->id();
            $table->string('question_ar')->change();
            $table->string('question_en')->change();
            $table->tinyInteger('status')->default('1')->nullable()->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('teacher_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('societies', function (Blueprint $table) {
            //
        });
    }
};
