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
                    'title_ar' => 'المجتمع',
                    'title_en' => 'Society',
                    'details_ar' => '<span style="color: rgb(0, 0, 0); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap; background-color: rgb(248, 248, 248);">تفضل باستكشاف مركز مجتمعنا النابض بالحياة، حيث يتواصل الأفراد ذوو التفكير المماثل، يتبادلون الأفكار، ويلهمون بعضهم البعض.</span>',
                    'details_en' => '<div dir="ltr"><span style="color: rgb(13, 13, 13); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 16px; white-space: pre-wrap;">Explore our vibrant community hub, where like-minded individuals connect, share ideas, and inspire one another.</span></div>',
                    'status' => '1',
                    'visits' => '0',
                    'webmaster_id' => '1',
                    'section_id' => '0',
                    'row_no' => '7',
                    'seo_title_ar' => 'المجتمع',
                    'seo_title_en' => 'Society',
                    'seo_description_ar' => 'تفضل باستكشاف مركز مجتمعنا النابض بالحياة، حيث يتواصل الأفراد ذوو التفكير المماثل، يتبادلون الأفكار، ويلهمون بعضهم البعض.',
                    'seo_description_en' => 'Explore our vibrant community hub, where like-minded individuals connect, share ideas, and inspire one another.',
                    'seo_url_slug_ar' => 'Society',
                    'seo_url_slug_en' => 'Society',
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
            // Rollback logic, if needed
            DB::table('topics')->truncate();
        });
    }
};
