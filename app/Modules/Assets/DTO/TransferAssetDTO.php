<?php

namespace App\Modules\Assets\DTO;

use App\Modules\Assets\Models\Asset;
use App\Modules\Organization\Models\Employee;
use Carbon\CarbonInterface;

final readonly class TransferAssetDTO
{
    public function __construct(
        public string $assetId,
        public Employee $employeeId,
        public CarbonInterface $transferredAt,
        public ?string $transferNotes  = null,
    )
    {
        
    }
}
