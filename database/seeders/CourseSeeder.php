<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Doctor;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'مقدمة في البرمجة',
                'description' => 'تعلم أساسيات البرمجة باستخدام PHP وLaravel.',
                'rating' => 4.5,
                'ratings_count' => 12,
                'price' => 500,
                'is_free' => false,
                'is_active' => true,
            ],
            [
                'title' => 'تطوير الويب المتقدم',
                'description' => 'دورة متقدمة لإتقان تطوير تطبيقات الويب الحديثة.',
                'rating' => 4.8,
                'ratings_count' => 20,
                'price' => 800,
                'is_free' => false,
                'is_active' => true,
            ],
            [
                'title' => 'أساسيات HTML مجانًا',
                'description' => 'دورة مجانية لتعلم أساسيات لغة HTML.',
                'rating' => 0,
                'ratings_count' => 0,
                'price' => 0,
                'is_free' => true,
                'is_active' => true,
            ],
            [
                'title' => 'الذكاء الاصطناعي وتعلم الآلة',
                'description' => 'مقدمة شاملة في الذكاء الاصطناعي وتطبيقات تعلم الآلة.',
                'rating' => 4.7,
                'ratings_count' => 15,
                'price' => 1000,
                'is_free' => false,
                'is_active' => true,
            ],
        ];

        $subjects = Subject::all();
        $doctors  = Doctor::all();

        foreach ($courses as $courseData) {
            if ($subjects->count() > 0) {
                $courseData['subject_id'] = $subjects->random()->id;
            }

            if ($doctors->count() > 0) {
                $courseData['doctor_id'] = $doctors->random()->id;
            }

            Course::create($courseData);
        }
    }
}
