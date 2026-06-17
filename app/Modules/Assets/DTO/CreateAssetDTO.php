<?php

namespace App\Modules\Assets\DTO;

use App\Modules\Assets\Requests\CreateAssetRequest;

final readonly class CreateAssetDTO
{
    public function __construct(
        public string $name,

        public int $assetCategoryId,

        public int $assetStatusId,

        public ?int $assetModelId = null,

        public ?int $supplierId = null,

        public ?string $assetTag = null,

        public ?string $serialNumber = null,

        public ?float $purchaseCost = null,

        public ?string $invoiceNumber = null,

        public ?string $purchaseDate = null,

        public ?string $warrantyExpirationDate = null,

        public ?string $criticality = null,

        public ?string $businessService = null,

        public ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],

            assetCategoryId: $data['asset_category_id'],

            assetStatusId: $data['asset_status_id'],

            assetModelId: $data['asset_model_id'] ?? null,

            supplierId: $data['supplier_id'] ?? null,

            assetTag: $data['asset_tag'] ?? null,

            serialNumber: $data['serial_number'] ?? null,

            purchaseCost: $data['purchase_cost'] ?? null,

            invoiceNumber: $data['invoice_number'] ?? null,

            purchaseDate: $data['purchase_date'] ?? null,

            warrantyExpirationDate: $data['warranty_expiration_date'] ?? null,

            criticality: $data['criticality'] ?? null,

            businessService: $data['business_service'] ?? null,

            notes: $data['notes'] ?? null,
        );
    }

    public static function fromRequest(CreateAssetRequest $request): self 
    {
        return self::fromArray(
            $request->validated()
        );
    }
}