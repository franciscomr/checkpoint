<?php

namespace App\Modules\Assets\Enums;

use App\Modules\Shared\Enums\EnumHelper;

enum AssetCriticality: string
{
    use EnumHelper;
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
        };
    }
/*
    public static function values(): array
    {
        return array_column(
            self::cases(),
            'value'
        );
    }
*/
}
