<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CollegeType;

class CollegeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can define the college types here if needed.
        // For example:
        // CollegeType::create(['name' => 'كلية الطب']);
        // CollegeType::create(['name' => 'كلية الهندسة']);
        // Add more college types as required.

        CollegeType::create(['name' => 'كلية الآداب']);
        CollegeType::create(['name' => 'كلية العلوم']);
        CollegeType::create(['name' => 'كلية الحقوق']);
        CollegeType::create(['name' => 'كلية التجارة']);
        CollegeType::create(['name' => 'كلية الطب']);
        CollegeType::create(['name' => 'كلية الهندسة']);
        CollegeType::create(['name' => 'كلية الحاسبات والمعلومات']);
        CollegeType::create(['name' => 'كلية الصيدلة']);
        CollegeType::create(['name' => 'كلية طب الأسنان']);
        CollegeType::create(['name' => 'كلية التربية']);
        CollegeType::create(['name' => 'كلية التربية الرياضية']);
    }
}
