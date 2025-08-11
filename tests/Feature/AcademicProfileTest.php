<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\University;
use App\Models\College;
use App\Models\Grade;
use App\Models\SecondarySchool;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcademicProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_university_profile_completion()
    {
        // Create test data
        $university = University::factory()->create(['name' => 'Test University']);
        $college = College::factory()->create([
            'name' => 'Test College',
            'university_id' => $university->id
        ]);
        $grade = Grade::factory()->create([
            'name' => 'First Year',
            'level' => 1,
            'college_id' => $college->id
        ]);

        $user = User::factory()->create([
            'phone' => '201234567890',
            'is_verified' => true
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/complete-profile', [
            'first_name' => 'Ahmed',
            'last_name' => 'Mohamed',
            'gender' => 'male',
            'academic_level' => 'university',
            'university_id' => $university->id,
            'college_id' => $college->id,
            'grade_id' => $grade->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertTrue($user->is_academic_details_set);
        $this->assertEquals($university->id, $user->university_id);
        $this->assertEquals($college->id, $user->college_id);
        $this->assertEquals($grade->id, $user->grade_id);
    }

    public function test_secondary_profile_completion_first_grade()
    {
        $school = SecondarySchool::factory()->create([
            'name' => 'Test School',
            'type' => SecondaryType::ARABIC
        ]);

        $user = User::factory()->create([
            'phone' => '201234567891',
            'is_verified' => true
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/complete-profile', [
            'first_name' => 'Fatima',
            'last_name' => 'Ali',
            'gender' => 'female',
            'academic_level' => 'secondary',
            'secondary_school_id' => $school->id,
            'secondary_grade' => 'first',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertTrue($user->is_academic_details_set);
        $this->assertEquals($school->id, $user->secondary_school_id);
        $this->assertEquals(SecondaryGrade::FIRST, $user->secondary_grade);
    }

    public function test_secondary_profile_completion_third_grade_scientific()
    {
        $school = SecondarySchool::factory()->create([
            'name' => 'Test School',
            'type' => SecondaryType::LANGUAGE
        ]);

        $user = User::factory()->create([
            'phone' => '201234567892',
            'is_verified' => true
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/complete-profile', [
            'first_name' => 'Omar',
            'last_name' => 'Hassan',
            'gender' => 'male',
            'academic_level' => 'secondary',
            'secondary_school_id' => $school->id,
            'secondary_grade' => 'third',
            'secondary_section' => 'scientific',
            'scientific_branch' => 'science',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertTrue($user->is_academic_details_set);
        $this->assertEquals($school->id, $user->secondary_school_id);
        $this->assertEquals(SecondaryGrade::THIRD, $user->secondary_grade);
        $this->assertEquals(SecondarySection::SCIENTIFIC, $user->secondary_section);
        $this->assertEquals(ScientificBranch::SCIENCE, $user->scientific_branch);
    }

    public function test_validation_error_missing_required_fields()
    {
        $user = User::factory()->create([
            'phone' => '201234567893',
            'is_verified' => true
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/complete-profile', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'gender' => 'male',
            'academic_level' => 'university',
            // Missing university_id, college_id, grade_id
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['university_id', 'college_id', 'grade_id']);
    }

    public function test_get_academic_data_endpoint()
    {
        $response = $this->getJson('/api/academic-data');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'universities',
                'secondary_grades',
                'secondary_sections',
                'scientific_branches'
            ]
        ]);
    }
}
