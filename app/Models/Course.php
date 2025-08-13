<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use mar3y\ImageUpload\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'title',
        'image',
        'description',
        'rating',
        'ratings_count',
        'price',
        'is_free',
        'is_active',
        'subject_id',
        'doctor_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Unit::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites', 'course_id', 'user_id');
    }

    public function isFavorited()
    {
        return $this->favoritedBy()->where('user_id', Auth::id())->exists();
    }
}
