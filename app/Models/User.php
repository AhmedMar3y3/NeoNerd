<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;
use Laravel\Sanctum\HasApiTokens;
use mar3y\ImageUpload\Traits\HasImage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'code',
        'is_verified',
        'gender',
        'academic_level',
        'image',
        'is_active',
        'fcm_token',
        // University flow fields
        'university_id',
        'college_id',
        'grade_id',
        // Secondary flow fields
        'secondary_type',
        'secondary_grade',
        'secondary_section',
        'scientific_branch',
        'is_academic_details_set',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => Gender::class,
        'academic_level' => AcademicLevel::class,
        'secondary_type' => SecondaryType::class,
        'secondary_grade' => SecondaryGrade::class,
        'secondary_section' => SecondarySection::class,
        'scientific_branch' => ScientificBranch::class,
        'is_academic_details_set' => 'boolean',
    ];

    protected static $imageAttributes = ['image'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function login()
    {
        return $this->createToken('user-token')->plainTextToken;
    }

    public function sendVerificationCode()
    {
        $this->update([
            'code' => random_int(100000, 999999),
            'is_verified' => false,
        ]);
    }

    public function markAsVerified()
    {
        $this->update(['is_verified' => true]);
    }

    public function profile_completed()
    {
        return $this->is_academic_details_set;
    }

    public function isUniversityStudent()
    {
        return $this->academic_level === AcademicLevel::UNIVERSITY;
    }

    public function isSecondaryStudent()
    {
        return $this->academic_level === AcademicLevel::SECONDARY;
    }

    public function favourites()
    {
        return $this->belongsToMany(Course::class, 'favourites', 'user_id', 'course_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('is_active', true);
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscriptions()->exists();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
