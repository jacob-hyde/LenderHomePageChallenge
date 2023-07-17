<?php

namespace App\Enum;

trait EnumToArray
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
