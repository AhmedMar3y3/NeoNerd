<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum SecondarySection: string
{
    use HasLocalizedEnum;
    
    case LITERAL = 'literal';
    case SCIENTIFIC = 'scientific';
}
