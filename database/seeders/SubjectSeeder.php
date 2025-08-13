<?php

namespace Database\Seeders;

use App\Enums\Term;
use App\Models\Subject;
use App\Models\CollegeType;
use App\Enums\AcademicLevel;
use App\Enums\SubjectType;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use Illuminate\Database\Seeder;

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
        $terms = [Term::FIRST, Term::SECOND];

        foreach ($collegeTypes as $collegeType) {
            // Common subjects for all college types
            $commonSubjects = [
                'اللغة العربية',
                'اللغة الإنجليزية',
                'الرياضيات',
                'الكمبيوتر',
            ];

            // Create subjects for each grade level (1-6) and term
            for ($gradeLevel = 1; $gradeLevel <= 6; $gradeLevel++) {
                foreach ($terms as $term) {
                    foreach ($commonSubjects as $subjectName) {
                        Subject::create([
                            'name' => $subjectName,
                            'academic_level' => AcademicLevel::UNIVERSITY,
                            'type' => SubjectType::BOTH,
                            'college_type_id' => $collegeType->id,
                            'grade_level' => $gradeLevel,
                            'term' => $term,
                            'is_active' => true,
                        ]);
                    }

                    // College-specific subjects
                    $collegeSpecificSubjects = $this->getCollegeSpecificSubjects($collegeType->name, $gradeLevel);
                    
                    foreach ($collegeSpecificSubjects as $subjectName) {
                        Subject::create([
                            'name' => $subjectName,
                            'academic_level' => AcademicLevel::UNIVERSITY,
                            'type' => SubjectType::SCIENTIFIC,
                            'college_type_id' => $collegeType->id,
                            'grade_level' => $gradeLevel,
                            'term' => $term,
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }

    private function createSecondarySubjects()
    {
        $secondaryTypes = [SecondaryType::ARABIC, SecondaryType::LANGUAGE];
        $grades = [SecondaryGrade::FIRST, SecondaryGrade::SECOND, SecondaryGrade::THIRD];
        $sections = [SecondarySection::LITERAL, SecondarySection::SCIENTIFIC];
        $terms = [Term::FIRST, Term::SECOND];

        foreach ($secondaryTypes as $secondaryType) {
            foreach ($grades as $grade) {
                foreach ($terms as $term) {
                    // Common subjects for all grades (no section required for first grade)
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
                            'academic_level' => AcademicLevel::SECONDARY,
                            'type' => $type,
                            'secondary_type' => $secondaryType,
                            'secondary_grade' => $grade,
                            'term' => $term,
                            'is_active' => true,
                        ]);
                    }

                    // Grade-specific subjects (only for 2nd and 3rd grades)
                    if ($grade === SecondaryGrade::SECOND || $grade === SecondaryGrade::THIRD) {
                        foreach ($sections as $section) {
                            $sectionSubjects = $this->getSectionSpecificSubjects($section);
                            
                            foreach ($sectionSubjects as $subjectName => $type) {
                                Subject::create([
                                    'name' => $subjectName,
                                    'academic_level' => AcademicLevel::SECONDARY,
                                    'type' => $type,
                                    'secondary_type' => $secondaryType,
                                    'secondary_grade' => $grade,
                                    'secondary_section' => $section,
                                    'term' => $term,
                                    'is_active' => true,
                                ]);
                            }
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

    private function getTypeLabel($type)
    {
        return match ($type) {
            SecondaryType::ARABIC => 'عربي',
            SecondaryType::LANGUAGE => 'لغات',
        };
    }
}
