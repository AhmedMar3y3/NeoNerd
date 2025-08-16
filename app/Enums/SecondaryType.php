<?php

namespace App\Enums;

use App\Traits\HasLocalizedEnum;

enum SecondaryType: string
{
    use HasLocalizedEnum;
    
    case ARABIC = 'arabic';
    case LANGUAGE = 'language';
}
