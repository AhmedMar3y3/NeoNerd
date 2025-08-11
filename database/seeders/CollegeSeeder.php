<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collegesByUniversity = [
            'جامعة القاهرة' => [
                'كلية الطب',
                'كلية الهندسة',
                'كلية العلوم',
                'كلية الحقوق',
                'كلية التجارة',
                'كلية الآداب',
                'كلية طب الأسنان',
                'كلية الصيدلة',
                'كلية الطب البيطري',
                'كلية الزراعة',
                'كلية دار العلوم',
                'كلية التربية',
                'كلية الحاسبات والمعلومات',
                'كلية التمريض',
                'كلية العلاج الطبيعي',
            ],
            'جامعة الأزهر' => [
                'كلية الشريعة والقانون',
                'كلية أصول الدين',
                'كلية اللغة العربية',
                'كلية الدراسات الإسلامية والعربية',
                'كلية الطب',
                'كلية الهندسة',
                'كلية العلوم',
                'كلية التجارة',
                'كلية التربية',
                'كلية طب الأسنان',
                'كلية الصيدلة',
            ],
            'جامعة عين شمس' => [
                'كلية الطب',
                'كلية الهندسة',
                'كلية العلوم',
                'كلية التجارة',
                'كلية الحقوق',
                'كلية الآداب',
                'كلية التربية',
                'كلية طب الأسنان',
                'كلية الصيدلة',
                'كلية الزراعة',
                'كلية الألسن',
                'كلية الحاسبات والمعلومات',
                'كلية التمريض',
                'كلية البنات للآداب والعلوم والتربية',
            ],
            'جامعة الإسكندرية' => [
                'كلية الطب',
                'كلية الهندسة',
                'كلية العلوم',
                'كلية الحقوق',
                'كلية التجارة',
                'كلية الآداب',
                'كلية طب الأسنان',
                'كلية الصيدلة',
                'كلية الطب البيطري',
                'كلية الزراعة',
                'كلية التربية',
                'كلية التمريض',
                'كلية الفنون الجميلة',
                'كلية التربية الرياضية',
            ],
        ];

        foreach ($collegesByUniversity as $universityName => $colleges) {
            $university = University::where('name', $universityName)->first();
            
            if ($university) {
                foreach ($colleges as $collegeName) {
                    College::create([
                        'name' => $collegeName,
                        'university_id' => $university->id,
                    ]);
                }
            }
        }

        // Add more colleges for other universities with common faculties
        $otherUniversities = University::whereNotIn('name', array_keys($collegesByUniversity))->get();
        $commonColleges = [
            'كلية الطب',
            'كلية الهندسة',
            'كلية العلوم',
            'كلية التجارة',
            'كلية الحقوق',
            'كلية الآداب',
            'كلية التربية',
            'كلية الزراعة',
        ];

        foreach ($otherUniversities as $university) {
            foreach ($commonColleges as $collegeName) {
                College::create([
                    'name' => $collegeName,
                    'university_id' => $university->id,
                ]);
            }
        }
    }
}
