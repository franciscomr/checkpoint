<?php

namespace App\Modules\Assets\Actions;

use App\Modules\Assets\DTO\CreateAssetDTO;
use App\Modules\Assets\Exceptions\AssetCreationException;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetModel;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Assets\Models\Supplier;
use App\Modules\Assets\Services\AssetTagGenerator;
use Illuminate\Support\Facades\DB;

class CreateAssetAction
{
        public function __construct(
        protected AssetTagGenerator $tagGenerator
    ) {}

    public function execute(CreateAssetDTO $dto): Asset
    {
        return DB::transaction(function () use ($dto) {

            $category = AssetCategory::query()
                ->find($dto->assetCategoryId);

            if (! $category) {
                throw AssetCreationException::categoryNotFound();
            }

            $status = AssetStatus::query()
                ->find($dto->assetStatusId);

            if (! $status) {
                throw AssetCreationException::statusNotFound();
            }

            if ($dto->assetModelId) {

                $model = AssetModel::query()
                    ->find($dto->assetModelId);

                if (! $model) {
                    throw AssetCreationException::modelNotFound();
                }
            }

            if ($dto->supplierId) {

                $supplier = Supplier::query()
                    ->find($dto->supplierId);

                if (! $supplier) {
                    throw AssetCreationException::supplierNotFound();
                }
            }

            $asset = Asset::query()->create([
                'asset_tag' => $dto->assetTag
                    ?? $this->tagGenerator->generate(),

                'name' => $dto->name,

                'asset_category_id' => $dto->assetCategoryId,

                'asset_status_id' => $dto->assetStatusId,

                'asset_model_id' => $dto->assetModelId,

                'supplier_id' => $dto->supplierId,

                'serial_number' => $dto->serialNumber,

                'purchase_cost' => $dto->purchaseCost,

                'invoice_number' => $dto->invoiceNumber,

                'purchase_date' => $dto->purchaseDate,

                'warranty_expiration_date'
                    => $dto->warrantyExpirationDate,

                'criticality' => $dto->criticality,

                'business_service'
                    => $dto->businessService,

                'notes' => $dto->notes,
            ]);

            return $asset->fresh([
                'category',
                'status',
                'model',
                'supplier',
            ]);
        });
    }
}
