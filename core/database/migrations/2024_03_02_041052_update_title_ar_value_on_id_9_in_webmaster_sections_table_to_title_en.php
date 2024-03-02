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
            DB::statement("
                UPDATE smartend_webmaster_sections
                SET title_ar = 'الشركاء'
                WHERE title_en = 'Partners'
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('webmaster_sections', function (Blueprint $table) {
            //
        });
    }
};
