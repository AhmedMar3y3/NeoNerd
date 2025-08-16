<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'unit_id',
        'num_of_questions',
        'is_free',
    ];

   public function unit()
   {
       return $this->belongsTo(Unit::class);
   }
}
