<?php

namespace App\Enums;

enum NodeType: string
{
    case SMALL = 'small';
    case NOTABLE = 'notable';
    case KEYSTONE = 'keystone';
    case ASCENDANCY = 'ascendancy';
}
