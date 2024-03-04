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
        Schema::table('topics', function (Blueprint $table) {
            DB::table('topics')->insert([
                [
                    'title_ar' => 'الخدمات الرئيسية',
                    'title_en' => 'Main Services',
                    'details_ar' => '<div dir="rtl"><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap;">صفحة الخدمات الرئيسية على موقعك على الويب هي بوابة لفهم عروضك - إنها حيث يجتمع الفضول بالوضوح، وحيث يجد الزوار الحلول لاحتياجاتهم.</span><br></div>',
                    'details_en' => '<div dir="ltr"><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap;"> Main Services page is the gateway to understanding your offerings – it is where curiosity meets clarity, and where visitors find the solutions to their needs.</span><br></div>',
                    'status' => '1',
                    'visits' => '0',
                    'webmaster_id' => '1',
                    'section_id' => '0',
                    'row_no' => '8',
                    'seo_title_ar' => 'الخدمات الرئيسية',
                    'seo_title_en' => 'main-services',
                    'seo_description_ar' => 'صفحة الخدمات الرئيسية على موقعك على الويب هي بوابة لفهم عروضك - إنها حيث يجتمع الفضول بالوضوح، وحيث يجد الزوار الحلول لاحتياجاتهم.',
                    'seo_description_en' => 'Main Services page is the gateway to understanding your offerings – it is where curiosity meets clarity, and where visitors find the solutions to their',
                    'seo_url_slug_ar' => 'main-services',
                    'seo_url_slug_en' => 'main-services',
                    'created_by' => '1',
                    'created_at' => now(),
                ],
                // Add more data as needed
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            //
        });
    }
};
