<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Seniority extends Enum
{
    const Junior =   0;
    const Intermediate =  1;
    const Senior = 2;
    const Internship = 3;
    
}
