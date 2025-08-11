<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function colleges()
    {
        return $this->hasMany(College::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getSubjectsForGrade($gradeLevel)
    {
        return $this->subjects()
            ->where('academic_level', 'university')
            ->where('grade_level', $gradeLevel)
            ->where('is_active', true)
            ->get();
    }
}
