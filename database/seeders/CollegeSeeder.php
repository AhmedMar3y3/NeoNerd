<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\CollegeType;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collegeTypes = CollegeType::all()->keyBy('name');

        $colleges = [
            [
                'name' => 'كلية الطب',
                'university_id' => 1, // Cairo University
                'college_type_id' => $collegeTypes['كلية الطب']->id,
            ],
            [
                'name' => 'كلية طب الأسنان',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية طب الأسنان']->id,
            ],
            [
                'name' => 'كلية الصيدلة',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية الصيدلة']->id,
            ],
            [
                'name' => 'كلية الهندسة',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية الهندسة']->id,
            ],
            [
                'name' => 'كلية الحاسبات والمعلومات',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية الحاسبات والمعلومات']->id,
            ],
            [
                'name' => 'كلية التجارة',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية التجارة']->id,
            ],
            [
                'name' => 'كلية الآداب',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية الآداب']->id,
            ],
            [
                'name' => 'كلية العلوم',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية العلوم']->id,
            ],
            [
                'name' => 'كلية التربية',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية التربية']->id,
            ],
            [
                'name' => 'كلية الحقوق',
                'university_id' => 1,
                'college_type_id' => $collegeTypes['كلية الحقوق']->id,
            ],
            // Alexandria University
            [
                'name' => 'كلية الطب',
                'university_id' => 2,
                'college_type_id' => $collegeTypes['كلية الطب']->id,
            ],
            [
                'name' => 'كلية الهندسة',
                'university_id' => 2,
                'college_type_id' => $collegeTypes['كلية الهندسة']->id,
            ],
            [
                'name' => 'كلية الحاسبات والمعلومات',
                'university_id' => 2,
                'college_type_id' => $collegeTypes['كلية الحاسبات والمعلومات']->id,
            ],
            [
                'name' => 'كلية التجارة',
                'university_id' => 2,
                'college_type_id' => $collegeTypes['كلية التجارة']->id,
            ],
            // Mansoura University
            [
                'name' => 'كلية الطب',
                'university_id' => 3,
                'college_type_id' => $collegeTypes['كلية الطب']->id,
            ],
            [
                'name' => 'كلية الهندسة',
                'university_id' => 3,
                'college_type_id' => $collegeTypes['كلية الهندسة']->id,
            ],
            [
                'name' => 'كلية الحاسبات والمعلومات',
                'university_id' => 3,
                'college_type_id' => $collegeTypes['كلية الحاسبات والمعلومات']->id,
            ],
        ];

        foreach ($colleges as $college) {
            College::create($college);
        }
    }
}
