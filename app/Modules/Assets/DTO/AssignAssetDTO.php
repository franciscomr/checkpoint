<?php

namespace App\Modules\Assets\DTO;
use Carbon\CarbonInterface;
final readonly class AssignAssetDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int|string $assetId, 
        public string $employeeId, 
        public CarbonInterface $assignedAt, 
        public ?CarbonInterface $expectedReturnAt = null, 
        public ?string $assignmentNotes = null,
    )
    {}
}
