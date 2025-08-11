<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    ];

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
        $this->update([
            'is_verified' => true,
            'code' => null,
        ]);
    }

    public function profile_completed()
    {
        return !is_null($this->academic_level);
    }
}
