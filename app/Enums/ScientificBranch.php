<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum ScientificBranch: string
{
    use HasLocalizedEnum;
    
    case SCIENCE = 'science';
    case MATH = 'math';
}
