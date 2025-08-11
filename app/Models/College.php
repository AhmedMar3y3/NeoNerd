<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'university_id', 'college_type_id'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function collegeType()
    {
        return $this->belongsTo(CollegeType::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, CollegeType::class);
    }

    // Helper method to get subjects for a specific grade level
    public function getSubjectsForGrade($gradeLevel)
    {
        return $this->collegeType->getSubjectsForGrade($gradeLevel);
    }
}
