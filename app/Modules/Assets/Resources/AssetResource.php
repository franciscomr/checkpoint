<?php

namespace App\Modules\Assets\Resources;

use App\Modules\Shared\Application\Resources\BaseApiResource;

class AssetResource extends BaseApiResource
{
    protected function data(): array
    {
        return [
            'asset_tag' => $this->asset_tag,

            'name' => $this->name,

            'serial_number' => $this->serial_number,

            'purchase_cost' => $this->purchase_cost,

            'invoice_number' => $this->invoice_number,

            'purchase_date' => $this->purchase_date,

            'warranty_expiration_date'
                => $this->warranty_expiration_date,

            'criticality' => $this->criticality,

            'business_service'
                => $this->business_service,

            'notes' => $this->notes,

            'category' => $this->whenLoaded(
                'category',
                fn () => [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ]
            ),

            'status' => $this->whenLoaded(
                'status',
                fn () => [
                    'id' => $this->status->id,
                    'name' => $this->status->name,
                ]
            ),

            'model' => $this->whenLoaded(
                'model',
                fn () => $this->model
                    ? [
                        'id' => $this->model->id,
                        'name' => $this->model->name,
                    ]
                    : null
            ),

            'supplier' => $this->whenLoaded(
                'supplier',
                fn () => $this->supplier
                    ? [
                        'id' => $this->supplier->id,
                        'name' => $this->supplier->name,
                    ]
                    : null
            ),
        ];
    }
}
