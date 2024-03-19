<?php

namespace Database\Seeders;

use App\Models\NewPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewPermission::insert([[
            'name_en' => 'Packages',
            'name_ar' => 'الباقات',
        ],[
            'name_en' => 'Financial Transactions',
            'name_ar' => 'القوائم المالية'
        ], [
            'name_en' => 'Purchases',
            'name_ar' => 'عمليات شراء الباقات',
        ],[
            'name_en' => 'Sliders',
            'name_ar' => 'السلايدر'
        ],[
            'name_en' => 'Clients',
            'name_ar' => 'العملاء'
        ],[
            'name_en' => 'Set Child to Specilist / Supervisor',
            'name_ar' => 'تعيين مشرفة و اخصائية للطفل'
        ],[
            'name_en' => 'Early Detection Reports',
            'name_ar' => 'تقارير الكشف المبكر',
        ], [
            'name_en' => 'Employees',
            'name_ar' => 'العاملين',
        ],[
            'name_en' => 'FAQs',
            'name_ar' => 'الاسئلة الشائعة',
        ],[
            'name_en' => 'Society',
            'name_ar' => 'المجتمع',
        ],[
            'name_en' => 'Services',
            'name_ar' => 'الخدمات',
        ],[
            'name_en' => 'Site pages',
            'name_ar' => 'صفحات الموقع'
        ], [
            'name_en' => 'Blog',
            'name_ar' => 'المدونة'
        ],[
            'name_en' => 'Partners',
            'name_ar' => 'الشركاء'
        ],[
            'name_en' => 'Website Settings',
            'name_ar' => 'اعدادات الموقع'
        ]
        ,[
            'name_en' => 'General Settings',
            'name_ar' => 'الاعدادات العامة'
        ]
    
    ]);
    }
}
