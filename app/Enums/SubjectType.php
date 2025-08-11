<?php

namespace App\Enums;

enum SubjectType: string
{
    case SCIENTIFIC = 'scientific';
    case LITERAL = 'literal';
    case BOTH = 'both';
}
