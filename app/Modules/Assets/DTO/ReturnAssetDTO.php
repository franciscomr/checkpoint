<?php

namespace App\Modules\Assets\DTO;

use Carbon\CarbonInterface;


final readonly class ReturnAssetDTO 
{
    public function __construct(
        public string $assetId,
        public CarbonInterface $returnedAt,
        public ?string $returnNotes = null,
    ){}

}