<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\College;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = College::all();

        foreach ($colleges as $college) {
            // Create grades for each college (typically 4-6 years)
            $gradeNames = [
                1 => 'السنة الأولى',
                2 => 'السنة الثانية',
                3 => 'السنة الثالثة',
                4 => 'السنة الرابعة',
                5 => 'السنة الخامسة',
                6 => 'السنة السادسة',
            ];

            // Most colleges have 4 years, some have 5 or 6
            $maxYears = in_array($college->name, ['كلية الطب', 'كلية طب الأسنان', 'كلية الصيدلة']) ? 6 : 4;

            for ($level = 1; $level <= $maxYears; $level++) {
                Grade::create([
                    'name' => $gradeNames[$level],
                    'level' => $level,
                    'college_id' => $college->id,
                ]);
            }
        }
    }
}
