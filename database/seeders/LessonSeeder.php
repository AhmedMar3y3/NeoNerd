<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Unit;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all units to create lessons for them
        $units = Unit::all();

        foreach ($units as $unit) {
            $this->createLessonsForUnit($unit);
        }

        $this->command->info('Lessons seeded successfully for all units!');
    }

    private function createLessonsForUnit($unit)
    {
        $lessons = [];

        // Course 1 - Anatomy
        if ($unit->course_id == 1) {
            switch ($unit->title) {
                case 'الوحدة الأولى: مقدمة في التشريح':
                    $lessons = [
                        ['title' => 'مقدمة في علم التشريح', 'duration' => '45:00', 'is_free' => true, 'video_url' => 'https://example.com/video1.mp4', 'has_file' => true],
                        ['title' => 'الأنسجة الأساسية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video2.mp4', 'has_file' => true],
                        ['title' => 'الجهاز الهيكلي', 'duration' => '75:00', 'is_free' => false, 'video_url' => 'https://example.com/video3.mp4', 'has_file' => false],
                    ];
                    break;
                case 'الوحدة الثانية: الجهاز العضلي':
                    $lessons = [
                        ['title' => 'أنواع العضلات', 'duration' => '50:00', 'is_free' => true, 'video_url' => 'https://example.com/video4.mp4', 'has_file' => true],
                        ['title' => 'الجهاز العضلي الهيكلي', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video5.mp4', 'has_file' => true],
                        ['title' => 'حركة العضلات', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video6.mp4', 'has_file' => false],
                        ['title' => 'أمراض العضلات', 'duration' => '40:00', 'is_free' => false, 'video_url' => 'https://example.com/video7.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الثالثة: الجهاز العصبي':
                    $lessons = [
                        ['title' => 'مقدمة في الجهاز العصبي', 'duration' => '45:00', 'is_free' => true, 'video_url' => 'https://example.com/video8.mp4', 'has_file' => true],
                        ['title' => 'الخلايا العصبية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video9.mp4', 'has_file' => true],
                        ['title' => 'الجهاز العصبي المركزي', 'duration' => '70:00', 'is_free' => false, 'video_url' => 'https://example.com/video10.mp4', 'has_file' => false],
                        ['title' => 'الجهاز العصبي المحيطي', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video11.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الرابعة: الجهاز الدوري':
                    $lessons = [
                        ['title' => 'مكونات الدم', 'duration' => '50:00', 'is_free' => true, 'video_url' => 'https://example.com/video12.mp4', 'has_file' => true],
                        ['title' => 'القلب والأوعية الدموية', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video13.mp4', 'has_file' => true],
                        ['title' => 'دورة الدم', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video14.mp4', 'has_file' => false],
                        ['title' => 'أمراض القلب والأوعية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video15.mp4', 'has_file' => true],
                    ];
                    break;
            }
        }

        // Course 2 - Chemistry
        if ($unit->course_id == 2) {
            switch ($unit->title) {
                case 'الوحدة الأولى: أساسيات الكيمياء العضوية':
                    $lessons = [
                        ['title' => 'مقدمة في الكيمياء العضوية', 'duration' => '40:00', 'is_free' => true, 'video_url' => 'https://example.com/video16.mp4', 'has_file' => true],
                        ['title' => 'الهيدروكربونات', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video17.mp4', 'has_file' => true],
                        ['title' => 'المجموعات الوظيفية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video18.mp4', 'has_file' => false],
                        ['title' => 'التسمية في الكيمياء العضوية', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video19.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الثانية: التفاعلات الكيميائية':
                    $lessons = [
                        ['title' => 'أنواع التفاعلات العضوية', 'duration' => '50:00', 'is_free' => true, 'video_url' => 'https://example.com/video20.mp4', 'has_file' => true],
                        ['title' => 'تفاعلات الإضافة', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video21.mp4', 'has_file' => true],
                        ['title' => 'تفاعلات الاستبدال', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video22.mp4', 'has_file' => false],
                        ['title' => 'تفاعلات الحذف', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video23.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الثالثة: الكيمياء الحيوية':
                    $lessons = [
                        ['title' => 'مقدمة في الكيمياء الحيوية', 'duration' => '40:00', 'is_free' => true, 'video_url' => 'https://example.com/video24.mp4', 'has_file' => true],
                        ['title' => 'الكربوهيدرات', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video25.mp4', 'has_file' => true],
                        ['title' => 'البروتينات', 'duration' => '70:00', 'is_free' => false, 'video_url' => 'https://example.com/video26.mp4', 'has_file' => false],
                        ['title' => 'الدهون', 'duration' => '50:00', 'is_free' => false, 'video_url' => 'https://example.com/video27.mp4', 'has_file' => true],
                        ['title' => 'الأحماض النووية', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video28.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الرابعة: التحليل الكيميائي':
                    $lessons = [
                        ['title' => 'أساسيات التحليل الكيميائي', 'duration' => '45:00', 'is_free' => true, 'video_url' => 'https://example.com/video29.mp4', 'has_file' => true],
                        ['title' => 'التحليل الكمي', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video30.mp4', 'has_file' => true],
                        ['title' => 'التحليل النوعي', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video31.mp4', 'has_file' => false],
                        ['title' => 'الأجهزة التحليلية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video32.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الخامسة: تطبيقات عملية':
                    $lessons = [
                        ['title' => 'التجارب العملية الأساسية', 'duration' => '90:00', 'is_free' => true, 'video_url' => 'https://example.com/video33.mp4', 'has_file' => true],
                        ['title' => 'تحضير المركبات العضوية', 'duration' => '75:00', 'is_free' => false, 'video_url' => 'https://example.com/video34.mp4', 'has_file' => true],
                        ['title' => 'فصل وتنقية المركبات', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video35.mp4', 'has_file' => false],
                        ['title' => 'تطبيقات في الصناعة', 'duration' => '50:00', 'is_free' => false, 'video_url' => 'https://example.com/video36.mp4', 'has_file' => true],
                    ];
                    break;
            }
        }

        // Course 4 - Medical Physics
        if ($unit->course_id == 4) {
            switch ($unit->title) {
                case 'الوحدة الأولى: مبادئ الفيزياء الطبية':
                    $lessons = [
                        ['title' => 'مقدمة في الفيزياء الطبية', 'duration' => '40:00', 'is_free' => true, 'video_url' => 'https://example.com/video37.mp4', 'has_file' => true],
                        ['title' => 'الكميات الفيزيائية الأساسية', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video38.mp4', 'has_file' => true],
                        ['title' => 'الوحدات والقياسات', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video39.mp4', 'has_file' => false],
                        ['title' => 'التحليل البعدي', 'duration' => '50:00', 'is_free' => false, 'video_url' => 'https://example.com/video40.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الثانية: الميكانيكا الحيوية':
                    $lessons = [
                        ['title' => 'مقدمة في الميكانيكا الحيوية', 'duration' => '45:00', 'is_free' => true, 'video_url' => 'https://example.com/video41.mp4', 'has_file' => true],
                        ['title' => 'حركة الجسم البشري', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video42.mp4', 'has_file' => true],
                        ['title' => 'القوى والطاقة في الجسم', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video43.mp4', 'has_file' => false],
                        ['title' => 'ميكانيكا العظام والمفاصل', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video44.mp4', 'has_file' => true],
                        ['title' => 'ميكانيكا العضلات', 'duration' => '50:00', 'is_free' => false, 'video_url' => 'https://example.com/video45.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الثالثة: الكهرباء والمغناطيسية في الطب':
                    $lessons = [
                        ['title' => 'أساسيات الكهرباء', 'duration' => '50:00', 'is_free' => true, 'video_url' => 'https://example.com/video46.mp4', 'has_file' => true],
                        ['title' => 'التيار الكهربائي في الجسم', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video47.mp4', 'has_file' => true],
                        ['title' => 'المغناطيسية في الطب', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video48.mp4', 'has_file' => false],
                        ['title' => 'التخطيط الكهربائي للقلب', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video49.mp4', 'has_file' => true],
                        ['title' => 'التخطيط الكهربائي للدماغ', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video50.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الرابعة: الإشعاع والتصوير الطبي':
                    $lessons = [
                        ['title' => 'مقدمة في الإشعاع', 'duration' => '45:00', 'is_free' => true, 'video_url' => 'https://example.com/video51.mp4', 'has_file' => true],
                        ['title' => 'الأشعة السينية', 'duration' => '70:00', 'is_free' => false, 'video_url' => 'https://example.com/video52.mp4', 'has_file' => true],
                        ['title' => 'التصوير المقطعي', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video53.mp4', 'has_file' => false],
                        ['title' => 'التصوير بالرنين المغناطيسي', 'duration' => '75:00', 'is_free' => false, 'video_url' => 'https://example.com/video54.mp4', 'has_file' => true],
                        ['title' => 'الطب النووي', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video55.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة الخامسة: الموجات الصوتية والموجات فوق الصوتية':
                    $lessons = [
                        ['title' => 'أساسيات الموجات الصوتية', 'duration' => '50:00', 'is_free' => true, 'video_url' => 'https://example.com/video56.mp4', 'has_file' => true],
                        ['title' => 'الموجات فوق الصوتية', 'duration' => '65:00', 'is_free' => false, 'video_url' => 'https://example.com/video57.mp4', 'has_file' => true],
                        ['title' => 'التصوير بالموجات فوق الصوتية', 'duration' => '60:00', 'is_free' => false, 'video_url' => 'https://example.com/video58.mp4', 'has_file' => false],
                        ['title' => 'تطبيقات في التشخيص', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video59.mp4', 'has_file' => true],
                        ['title' => 'العلاج بالموجات فوق الصوتية', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video60.mp4', 'has_file' => true],
                    ];
                    break;
                case 'الوحدة السادسة: تطبيقات الفيزياء في العلاج':
                    $lessons = [
                        ['title' => 'العلاج الإشعاعي', 'duration' => '60:00', 'is_free' => true, 'video_url' => 'https://example.com/video61.mp4', 'has_file' => true],
                        ['title' => 'العلاج بالليزر', 'duration' => '55:00', 'is_free' => false, 'video_url' => 'https://example.com/video62.mp4', 'has_file' => true],
                        ['title' => 'العلاج الحراري', 'duration' => '50:00', 'is_free' => false, 'video_url' => 'https://example.com/video63.mp4', 'has_file' => false],
                        ['title' => 'العلاج بالكهرباء', 'duration' => '45:00', 'is_free' => false, 'video_url' => 'https://example.com/video64.mp4', 'has_file' => true],
                        ['title' => 'التطبيقات المستقبلية', 'duration' => '40:00', 'is_free' => false, 'video_url' => 'https://example.com/video65.mp4', 'has_file' => true],
                    ];
                    break;
            }
        }

        // Create lessons for this unit
        foreach ($lessons as $lessonData) {
            Lesson::create([
                'title' => $lessonData['title'],
                'unit_id' => $unit->id,
                'duration' => $lessonData['duration'],
                'is_free' => $lessonData['is_free'],
                'video_url' => $lessonData['video_url'],
                'has_file' => $lessonData['has_file'],
                'file' => $lessonData['has_file'] ? 'sample_file.pdf' : null,
            ]);
        }
    }
}
