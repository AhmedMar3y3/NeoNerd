<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Course 1 Units
        Unit::create([
            'title' => 'الوحدة الأولى: مقدمة في التشريح',
            'course_id' => 1,
        ]);

        Unit::create([
            'title' => 'الوحدة الثانية: الجهاز العضلي',
            'course_id' => 1,
        ]);

        Unit::create([
            'title' => 'الوحدة الثالثة: الجهاز العصبي',
            'course_id' => 1,
        ]);

        Unit::create([
            'title' => 'الوحدة الرابعة: الجهاز الدوري',
            'course_id' => 1,
        ]);

        // Course 2 Units
        Unit::create([
            'title' => 'الوحدة الأولى: أساسيات الكيمياء العضوية',
            'course_id' => 2,
        ]);

        Unit::create([
            'title' => 'الوحدة الثانية: التفاعلات الكيميائية',
            'course_id' => 2,
        ]);

        Unit::create([
            'title' => 'الوحدة الثالثة: الكيمياء الحيوية',
            'course_id' => 2,
        ]);

        Unit::create([
            'title' => 'الوحدة الرابعة: التحليل الكيميائي',
            'course_id' => 2,
        ]);

        Unit::create([
            'title' => 'الوحدة الخامسة: تطبيقات عملية',
            'course_id' => 2,
        ]);

        // Course 4 Units
        Unit::create([
            'title' => 'الوحدة الأولى: مبادئ الفيزياء الطبية',
            'course_id' => 4,
        ]);

        Unit::create([
            'title' => 'الوحدة الثانية: الميكانيكا الحيوية',
            'course_id' => 4,
        ]);

        Unit::create([
            'title' => 'الوحدة الثالثة: الكهرباء والمغناطيسية في الطب',
            'course_id' => 4,
        ]);

        Unit::create([
            'title' => 'الوحدة الرابعة: الإشعاع والتصوير الطبي',
            'course_id' => 4,
        ]);

        Unit::create([
            'title' => 'الوحدة الخامسة: الموجات الصوتية والموجات فوق الصوتية',
            'course_id' => 4,
        ]);

        Unit::create([
            'title' => 'الوحدة السادسة: تطبيقات الفيزياء في العلاج',
            'course_id' => 4,
        ]);

        $this->command->info('Units seeded successfully for courses 1, 2, and 4!');
    }
}
