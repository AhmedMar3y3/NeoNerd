<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AcademicLevel;
use App\Enums\SubjectType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'academic_level',
        'type',
        'college_type_id',
        'grade_level',
        'secondary_type_id',
        'secondary_grade',
        'secondary_section',
        'is_active',
    ];

    protected $casts = [
        'academic_level' => AcademicLevel::class,
        'type' => SubjectType::class,
        'secondary_grade' => SecondaryGrade::class,
        'secondary_section' => SecondarySection::class,
        'is_active' => 'boolean',
    ];

    // Relationships
    public function collegeType()
    {
        return $this->belongsTo(CollegeType::class);
    }

    public function secondaryType()
    {
        return $this->belongsTo(SecondaryType::class);
    }

    // Scopes for filtering
    public function scopeUniversity($query)
    {
        return $query->where('academic_level', AcademicLevel::UNIVERSITY);
    }

    public function scopeSecondary($query)
    {
        return $query->where('academic_level', AcademicLevel::SECONDARY);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCollegeType($query, $collegeTypeId)
    {
        return $query->where('college_type_id', $collegeTypeId);
    }

    public function scopeByGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    public function scopeBySecondaryType($query, $secondaryTypeId)
    {
        return $query->where('secondary_type_id', $secondaryTypeId);
    }

    public function scopeBySecondaryGrade($query, $grade)
    {
        return $query->where('secondary_grade', $grade);
    }

    public function scopeBySecondarySection($query, $section)
    {
        return $query->where('secondary_section', $section);
    }

    public function scopeBySubjectType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods
    public function isUniversitySubject()
    {
        return $this->academic_level === AcademicLevel::UNIVERSITY;
    }

    public function isSecondarySubject()
    {
        return $this->academic_level === AcademicLevel::SECONDARY;
    }

    public function isScientificSubject()
    {
        return $this->type === SubjectType::SCIENTIFIC;
    }

    public function isLiteralSubject()
    {
        return $this->type === SubjectType::LITERAL;
    }

    public function isBothSubject()
    {
        return $this->type === SubjectType::BOTH;
    }

    // Get subjects for a specific user based on their academic profile
    public static function getSubjectsForUser(User $user)
    {
        if ($user->isUniversityStudent()) {
            $college = $user->college;
            $grade = $user->grade;
            
            return static::university()
                ->active()
                ->byCollegeType($college->college_type_id)
                ->byGradeLevel($grade->level)
                ->get();
        } else {
            return static::secondary()
                ->active()
                ->bySecondaryType($user->secondary_type_id)
                ->bySecondaryGrade($user->secondary_grade)
                ->where(function ($query) use ($user) {
                    if ($user->secondary_section) {
                        $query->where('secondary_section', $user->secondary_section)
                              ->orWhere('type', SubjectType::BOTH);
                    }
                })
                ->get();
        }
    }

    // Get subjects for a specific college type and grade level (for university)
    public static function getSubjectsForCollegeType($collegeTypeId, $gradeLevel)
    {
        return static::university()
            ->active()
            ->byCollegeType($collegeTypeId)
            ->byGradeLevel($gradeLevel)
            ->get();
    }

    // Get subjects for a specific college and grade (for university) - convenience method
    public static function getSubjectsForCollegeGrade($collegeId, $gradeLevel)
    {
        $college = College::find($collegeId);
        if (!$college) {
            return collect();
        }
        
        return static::getSubjectsForCollegeType($college->college_type_id, $gradeLevel);
    }

    // Get subjects for a specific secondary type, grade and section
    public static function getSubjectsForSecondaryType($secondaryTypeId, $grade, $section = null)
    {
        $query = static::secondary()
            ->active()
            ->bySecondaryType($secondaryTypeId)
            ->bySecondaryGrade($grade);

        if ($section) {
            $query->where(function ($q) use ($section) {
                $q->where('secondary_section', $section)
                  ->orWhere('type', SubjectType::BOTH);
            });
        }

        return $query->get();
    }

    // Get subjects for a specific secondary grade and section (legacy method)
    public static function getSubjectsForSecondaryGrade($grade, $section = null)
    {
        $query = static::secondary()
            ->active()
            ->bySecondaryGrade($grade);

        if ($section) {
            $query->where(function ($q) use ($section) {
                $q->where('secondary_section', $section)
                  ->orWhere('type', SubjectType::BOTH);
            });
        }

        return $query->get();
    }
}
