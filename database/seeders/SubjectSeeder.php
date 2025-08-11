<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\CollegeType;
use App\Models\SecondaryType;
use App\Enums\AcademicLevel;
use App\Enums\SubjectType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create university subjects
        $this->createUniversitySubjects();
        
        // Create secondary subjects
        $this->createSecondarySubjects();
    }

    private function createUniversitySubjects()
    {
        $collegeTypes = CollegeType::all();

        foreach ($collegeTypes as $collegeType) {
            // Common subjects for all college types
            $commonSubjects = [
                'اللغة العربية',
                'اللغة الإنجليزية',
                'الرياضيات',
                'الكمبيوتر',
            ];

            // Create subjects for each grade level (1-6)
            for ($gradeLevel = 1; $gradeLevel <= 6; $gradeLevel++) {
                foreach ($commonSubjects as $subjectName) {
                    Subject::create([
                        'name' => $subjectName,
                        'description' => "مادة {$subjectName} للسنة {$gradeLevel}",
                        'academic_level' => AcademicLevel::UNIVERSITY,
                        'college_type_id' => $collegeType->id,
                        'grade_level' => $gradeLevel,
                        'is_active' => true,
                    ]);
                }

                // College-specific subjects
                $collegeSpecificSubjects = $this->getCollegeSpecificSubjects($collegeType->name, $gradeLevel);
                
                foreach ($collegeSpecificSubjects as $subjectName) {
                    Subject::create([
                        'name' => $subjectName,
                        'description' => "مادة {$subjectName} للسنة {$gradeLevel} في {$collegeType->name}",
                        'academic_level' => AcademicLevel::UNIVERSITY,
                        'college_type_id' => $collegeType->id,
                        'grade_level' => $gradeLevel,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }

    private function createSecondarySubjects()
    {
        $secondaryTypes = SecondaryType::all();
        $grades = [SecondaryGrade::FIRST, SecondaryGrade::SECOND, SecondaryGrade::THIRD];
        $sections = [SecondarySection::LITERAL, SecondarySection::SCIENTIFIC];

        foreach ($secondaryTypes as $secondaryType) {
            foreach ($grades as $grade) {
                // Common subjects for all grades
                $commonSubjects = [
                    'اللغة العربية' => SubjectType::BOTH,
                    'اللغة الإنجليزية' => SubjectType::BOTH,
                    'الرياضيات' => SubjectType::SCIENTIFIC,
                    'العلوم' => SubjectType::SCIENTIFIC,
                    'الدراسات الاجتماعية' => SubjectType::LITERAL,
                    'التربية الدينية' => SubjectType::BOTH,
                    'الكمبيوتر' => SubjectType::BOTH,
                ];

                foreach ($commonSubjects as $subjectName => $type) {
                    Subject::create([
                        'name' => $subjectName,
                        'description' => "مادة {$subjectName} للصف {$this->getGradeLabel($grade)} - {$secondaryType->name}",
                        'academic_level' => AcademicLevel::SECONDARY,
                        'type' => $type,
                        'secondary_type_id' => $secondaryType->id,
                        'secondary_grade' => $grade,
                        'is_active' => true,
                    ]);
                }

                // Grade-specific subjects
                if ($grade === SecondaryGrade::SECOND || $grade === SecondaryGrade::THIRD) {
                    foreach ($sections as $section) {
                        $sectionSubjects = $this->getSectionSpecificSubjects($section);
                        
                        foreach ($sectionSubjects as $subjectName => $type) {
                            Subject::create([
                                'name' => $subjectName,
                                'description' => "مادة {$subjectName} للصف {$this->getGradeLabel($grade)} - {$this->getSectionLabel($section)} - {$secondaryType->name}",
                                'academic_level' => AcademicLevel::SECONDARY,
                                'type' => $type,
                                'secondary_type_id' => $secondaryType->id,
                                'secondary_grade' => $grade,
                                'secondary_section' => $section,
                                'is_active' => true,
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function getCollegeSpecificSubjects($collegeTypeName, $gradeLevel)
    {
        $subjects = [];

        switch ($collegeTypeName) {
            case 'كلية الطب':
                $subjects = [
                    'علم التشريح',
                    'علم وظائف الأعضاء',
                    'علم الأحياء الدقيقة',
                    'علم الأمراض',
                    'علم الأدوية',
                    'طب المجتمع',
                ];
                break;
            case 'كلية الهندسة':
                $subjects = [
                    'الرياضيات الهندسية',
                    'الفيزياء الهندسية',
                    'الكيمياء الهندسية',
                    'الرسم الهندسي',
                    'ميكانيكا المواد',
                    'الدوائر الكهربائية',
                ];
                break;
            case 'كلية الحاسبات والمعلومات':
                $subjects = [
                    'برمجة الحاسوب',
                    'قواعد البيانات',
                    'شبكات الحاسوب',
                    'هندسة البرمجيات',
                    'الذكاء الاصطناعي',
                    'أمن المعلومات',
                ];
                break;
            case 'كلية التجارة':
                $subjects = [
                    'مبادئ المحاسبة',
                    'إدارة الأعمال',
                    'الاقتصاد',
                    'التسويق',
                    'التمويل',
                    'نظم المعلومات',
                ];
                break;
            case 'كلية الآداب':
                $subjects = [
                    'الأدب العربي',
                    'النقد الأدبي',
                    'علم النفس',
                    'علم الاجتماع',
                    'التاريخ',
                    'الجغرافيا',
                ];
                break;
            default:
                $subjects = [
                    'مادة تخصصية 1',
                    'مادة تخصصية 2',
                    'مادة تخصصية 3',
                ];
        }

        // Return only subjects for the specific grade level
        return array_slice($subjects, 0, min($gradeLevel, count($subjects)));
    }

    private function getSectionSpecificSubjects($section)
    {
        if ($section === SecondarySection::SCIENTIFIC) {
            return [
                'الفيزياء' => SubjectType::SCIENTIFIC,
                'الكيمياء' => SubjectType::SCIENTIFIC,
                'الأحياء' => SubjectType::SCIENTIFIC,
                'الجيولوجيا' => SubjectType::SCIENTIFIC,
            ];
        } else {
            return [
                'الفلسفة' => SubjectType::LITERAL,
                'علم النفس' => SubjectType::LITERAL,
                'علم الاجتماع' => SubjectType::LITERAL,
                'الجغرافيا' => SubjectType::LITERAL,
            ];
        }
    }

    private function getGradeLabel($grade)
    {
        return match ($grade) {
            SecondaryGrade::FIRST => 'الأول الثانوي',
            SecondaryGrade::SECOND => 'الثاني الثانوي',
            SecondaryGrade::THIRD => 'الثالث الثانوي',
        };
    }

    private function getSectionLabel($section)
    {
        return match ($section) {
            SecondarySection::LITERAL => 'أدبي',
            SecondarySection::SCIENTIFIC => 'علمي',
        };
    }
}
