<?php

namespace App\Models;

use App\Enums\Term; 
use App\Enums\SubjectType; 
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use mar3y\ImageUpload\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'name',
        'term',
        'image',
        'academic_level',
        'type',
        'college_type_id',
        'grade_level',
        'secondary_type',
        'secondary_grade',
        'secondary_section',
        'is_active',
    ];

    protected $casts = [
        'academic_level' => AcademicLevel::class,
        'type' => SubjectType::class,
        'secondary_grade' => SecondaryGrade::class,
        'secondary_section' => SecondarySection::class,
        'secondary_type' => SecondaryType::class,
        'term' => Term::class,
        'is_active' => 'boolean',
    ];

    // Relationships
    public function collegeType()
    {
        return $this->belongsTo(CollegeType::class);
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

    public function scopeBySecondaryType($query, $secondaryType)
    {
        return $query->where('secondary_type', $secondaryType);
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

    public static function getSubjectsForUser(User $user, $term = null)
    {
        // Default to first term if not provided
        $term = $term ?? Term::FIRST;
        
        if ($user->isUniversityStudent()) {
            $college = $user->college;
            $grade = $user->grade;
            
            return static::university()
                ->active()
                ->byCollegeType($college->college_type_id)
                ->byGradeLevel($grade->level)
                ->where('term', $term)
                ->get();
        } else {
            return static::secondary()
                ->active()
                ->bySecondaryType($user->secondary_type)
                ->bySecondaryGrade($user->secondary_grade)
                ->where('term', $term)
                ->where(function ($query) use ($user) {
                    if ($user->secondary_section) {
                        $query->where('secondary_section', $user->secondary_section)
                              ->orWhere('type', SubjectType::BOTH);
                    }
                })
                ->get();
        }
    }
}
