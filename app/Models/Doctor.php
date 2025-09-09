<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use mar3y\ImageUpload\Traits\HasImage;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable, HasImage;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'specialization',
        'bio',
        'image',
        'is_active',
        'university_id',
        'is_profile_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_profile_completed' => 'boolean',
    ];

    protected static $imageAttributes = ['image'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class);
    }
}
