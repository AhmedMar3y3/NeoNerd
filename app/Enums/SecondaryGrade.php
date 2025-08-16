<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum SecondaryGrade: string
{
    use HasLocalizedEnum;
    
    case FIRST = 'first';
    case SECOND = 'second';
    case THIRD = 'third';
}
