<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SecondaryType as SecondaryTypeEnum;

class SecondaryType extends Model
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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method to get subjects for a specific grade and section
    public function getSubjectsForGrade($grade, $section = null)
    {
        $query = $this->subjects()
            ->where('academic_level', 'secondary')
            ->where('secondary_grade', $grade)
            ->where('is_active', true);

        if ($section) {
            $query->where(function ($q) use ($section) {
                $q->where('secondary_section', $section)
                  ->orWhere('type', 'both');
            });
        }

        return $query->get();
    }
}
