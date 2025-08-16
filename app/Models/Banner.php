<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mar3y\ImageUpload\Traits\HasImage;

class Banner extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['title', 'image'];
    protected static $imageAttributes = ['image'];
}
