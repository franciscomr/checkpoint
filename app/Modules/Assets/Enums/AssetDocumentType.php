<?php

namespace App\Modules\Assets\Enums;

enum AssetDocumentType: string
{
    case INVOICE = 'invoice';

    case WARRANTY = 'warranty';

    case MANUAL = 'manual';

    case ASSIGNMENT_LETTER = 'assignment_letter';

    case PHOTO = 'photo';

    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::INVOICE => 'Invoice',
            self::WARRANTY => 'Warranty',
            self::MANUAL => 'Manual',
            self::ASSIGNMENT_LETTER => 'Assignment Letter',
            self::PHOTO => 'Photo',
            self::OTHER => 'Other',
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
