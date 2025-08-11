<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Subject;
use App\Models\University;
use App\Models\College;
use App\Models\Grade;
use App\Models\SecondarySchool;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\SubjectType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_university_subjects_for_user()
    {
        // Create test data
        $university = University::factory()->create(['name' => 'Test University']);
        $college = College::factory()->create([
            'name' => 'كلية الطب',
            'university_id' => $university->id
        ]);
        $grade = Grade::factory()->create([
            'name' => 'السنة الأولى',
            'level' => 1,
            'college_id' => $college->id
        ]);

        // Create subjects for this grade
        $subjects = [
            Subject::factory()->create([
                'name' => 'علم التشريح',
                'academic_level' => AcademicLevel::UNIVERSITY,
                'grade_id' => $grade->id,
            ]),
            Subject::factory()->create([
                'name' => 'علم وظائف الأعضاء',
                'academic_level' => AcademicLevel::UNIVERSITY,
                'grade_id' => $grade->id,
            ]),
        ];

        $user = User::factory()->create([
            'phone' => '201234567890',
            'is_verified' => true,
            'academic_level' => AcademicLevel::UNIVERSITY,
            'university_id' => $university->id,
            'college_id' => $college->id,
            'grade_id' => $grade->id,
            'is_academic_details_set' => true,
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/subjects/user');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'academic_level',
                    'grade_id',
                ]
            ]
        ]);
    }

    public function test_secondary_subjects_for_user_first_grade()
    {
        $school = SecondarySchool::factory()->create([
            'name' => 'Test School',
            'type' => SecondaryType::ARABIC
        ]);

        $user = User::factory()->create([
            'phone' => '201234567891',
            'is_verified' => true,
            'academic_level' => AcademicLevel::SECONDARY,
            'secondary_school_id' => $school->id,
            'secondary_grade' => SecondaryGrade::FIRST,
            'is_academic_details_set' => true,
        ]);

        // Create subjects for first grade
        $subjects = [
            Subject::factory()->create([
                'name' => 'اللغة العربية',
                'academic_level' => AcademicLevel::SECONDARY,
                'type' => SubjectType::BOTH,
                'secondary_grade' => SecondaryGrade::FIRST,
            ]),
            Subject::factory()->create([
                'name' => 'الرياضيات',
                'academic_level' => AcademicLevel::SECONDARY,
                'type' => SubjectType::SCIENTIFIC,
                'secondary_grade' => SecondaryGrade::FIRST,
            ]),
        ];

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/subjects/user');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_secondary_subjects_for_user_third_grade_scientific()
    {
        $school = SecondarySchool::factory()->create([
            'name' => 'Test School',
            'type' => SecondaryType::LANGUAGE
        ]);

        $user = User::factory()->create([
            'phone' => '201234567892',
            'is_verified' => true,
            'academic_level' => AcademicLevel::SECONDARY,
            'secondary_school_id' => $school->id,
            'secondary_grade' => SecondaryGrade::THIRD,
            'secondary_section' => SecondarySection::SCIENTIFIC,
            'is_academic_details_set' => true,
        ]);

        // Create subjects for third grade scientific
        $subjects = [
            Subject::factory()->create([
                'name' => 'اللغة العربية',
                'academic_level' => AcademicLevel::SECONDARY,
                'type' => SubjectType::BOTH,
                'secondary_grade' => SecondaryGrade::THIRD,
            ]),
            Subject::factory()->create([
                'name' => 'الفيزياء',
                'academic_level' => AcademicLevel::SECONDARY,
                'type' => SubjectType::SCIENTIFIC,
                'secondary_grade' => SecondaryGrade::THIRD,
                'secondary_section' => SecondarySection::SCIENTIFIC,
            ]),
        ];

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/subjects/user');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_subjects_by_college_grade_endpoint()
    {
        $university = University::factory()->create();
        $college = College::factory()->create(['university_id' => $university->id]);
        $grade = Grade::factory()->create([
            'college_id' => $college->id,
            'level' => 1
        ]);

        Subject::factory()->create([
            'academic_level' => AcademicLevel::UNIVERSITY,
            'grade_id' => $grade->id,
        ]);

        $response = $this->getJson("/api/subjects/college-grade?college_id={$college->id}&grade_level=1");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_subjects_by_secondary_grade_endpoint()
    {
        Subject::factory()->create([
            'name' => 'اللغة العربية',
            'academic_level' => AcademicLevel::SECONDARY,
            'type' => SubjectType::BOTH,
            'secondary_grade' => SecondaryGrade::FIRST,
        ]);

        $response = $this->getJson("/api/subjects/secondary-grade?grade=first");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_subjects_by_academic_level_endpoint()
    {
        Subject::factory()->create([
            'academic_level' => AcademicLevel::UNIVERSITY,
        ]);

        Subject::factory()->create([
            'academic_level' => AcademicLevel::SECONDARY,
        ]);

        $response = $this->getJson("/api/subjects/academic-level?academic_level=university");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_user_subjects_without_completed_profile()
    {
        $user = User::factory()->create([
            'phone' => '201234567893',
            'is_verified' => true,
            'is_academic_details_set' => false,
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/subjects/user');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'يجب إكمال الملف الشخصي الأكاديمي أولاً'
        ]);
    }

    public function test_cross_university_subject_compatibility()
    {
        // Create two universities with same college
        $university1 = University::factory()->create(['name' => 'University 1']);
        $university2 = University::factory()->create(['name' => 'University 2']);
        
        $college1 = College::factory()->create([
            'name' => 'كلية الطب',
            'university_id' => $university1->id
        ]);
        $college2 = College::factory()->create([
            'name' => 'كلية الطب',
            'university_id' => $university2->id
        ]);

        $grade1 = Grade::factory()->create([
            'name' => 'السنة الأولى',
            'level' => 1,
            'college_id' => $college1->id
        ]);
        $grade2 = Grade::factory()->create([
            'name' => 'السنة الأولى',
            'level' => 1,
            'college_id' => $college2->id
        ]);

        // Create same subjects for both grades
        $subjectName = 'علم التشريح';
        Subject::factory()->create([
            'name' => $subjectName,
            'academic_level' => AcademicLevel::UNIVERSITY,
            'grade_id' => $grade1->id,
        ]);
        Subject::factory()->create([
            'name' => $subjectName,
            'academic_level' => AcademicLevel::UNIVERSITY,
            'grade_id' => $grade2->id,
        ]);

        // Test that both users get the same subject
        $user1 = User::factory()->create([
            'academic_level' => AcademicLevel::UNIVERSITY,
            'university_id' => $university1->id,
            'college_id' => $college1->id,
            'grade_id' => $grade1->id,
            'is_academic_details_set' => true,
        ]);

        $user2 = User::factory()->create([
            'academic_level' => AcademicLevel::UNIVERSITY,
            'university_id' => $university2->id,
            'college_id' => $college2->id,
            'grade_id' => $grade2->id,
            'is_academic_details_set' => true,
        ]);

        $subjects1 = Subject::getSubjectsForUser($user1);
        $subjects2 = Subject::getSubjectsForUser($user2);

        $this->assertEquals($subjects1->count(), $subjects2->count());
        $this->assertEquals($subjects1->first()->name, $subjects2->first()->name);
    }
}
