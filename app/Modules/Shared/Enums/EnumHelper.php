<?php

namespace App\Modules\Shared\Enums;

trait EnumHelper
{
    public static function values(): array
    {
        return array_column(
            static::cases(),
            'value'
        );
    }

    public static function labels(): array
    {
        return collect(static::cases())
            ->mapWithKeys(
                fn ($case) => [$case->value => $case->label()]
            )
            ->toArray();
    }
}
