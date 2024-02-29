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
            // Insert data into the table
            DB::table('topics')->insert([
                [
                    'title_ar' => 'الباقات',
                    'title_en' => 'Packages',
                    'details_ar' => '<div dir="rtl"><br></div><div dir="rtl"><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap;">اكتشف مجموعتنا من الحزم المصممة خصيصًا لتلبية احتياجاتك ورفع تجربتك إلى آفاق جديدة.</span><br></div>',
                    'details_en' => '<div dir="ltr"><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap;">Discover our range of tailored packages designed to meet your needs and elevate your experience to new heights.</span><br></div>',
                    'status' => '1',
                    'visits' => '0',
                    'webmaster_id' => '1',
                    'section_id' => '0',
                    'row_no' => '8',
                    'seo_title_ar' => 'الباقات',
                    'seo_title_en' => 'Packages',
                    'seo_description_ar' => 'اكتشف مجموعتنا من الحزم المصممة خصيصًا لتلبية احتياجاتك ورفع تجربتك إلى آفاق جديدة.',
                    'seo_description_en' => 'Discover our range of tailored packages designed to meet your needs and elevate your experience to new heights.',
                    'seo_url_slug_ar' => 'Packages',
                    'seo_url_slug_en' => 'Packages',
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

        });
    }
};
