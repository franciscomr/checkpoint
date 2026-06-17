<?php

namespace App\Modules\Assets\Enums;

enum AssetMovementType: string
{
    case CREATED = 'created';

    case ASSIGNED = 'assigned';

    case TRANSFERRED = 'transferred';

    case RETURNED = 'returned';

    case MAINTENANCE = 'maintenance';

    case RETIRED = 'retired';

    case DISPOSED = 'disposed';

    public function label(): string
    {
        return match ($this) {
            self::CREATED => 'Created',
            self::ASSIGNED => 'Assigned',
            self::TRANSFERRED => 'Transferred',
            self::RETURNED => 'Returned',
            self::MAINTENANCE => 'Maintenance',
            self::RETIRED => 'Retired',
            self::DISPOSED => 'Disposed',
        };
    }

    public static function values(): array
    {
        return array_column(
            self::cases(),
            'value'
        );
    }
}
