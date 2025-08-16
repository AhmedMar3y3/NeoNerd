<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum SubjectType: string
{
    use HasLocalizedEnum;
    
    case SCIENTIFIC = 'scientific';
    case LITERAL = 'literal';
    case BOTH = 'both';
}
