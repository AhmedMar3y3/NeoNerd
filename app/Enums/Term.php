<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum Term: string
{
    use HasLocalizedEnum;
    
    case FIRST = 'first';
    case SECOND = 'second';
}
