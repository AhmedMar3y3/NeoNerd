<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum AcademicLevel: string
{
    use HasLocalizedEnum;
    
    case UNIVERSITY = 'university';
    case SECONDARY = 'secondary';
}