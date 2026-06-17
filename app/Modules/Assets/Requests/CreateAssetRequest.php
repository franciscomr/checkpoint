<?php

namespace App\Modules\Assets\Requests;

use App\Modules\Assets\DTO\CreateAssetDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Modules\Assets\Enums\AssetCriticality;

class CreateAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
                return [
            'name' => ['required', 'string', 'max:255'],

            'asset_category_id' => ['required', 'integer'],

            'asset_status_id' => ['required', 'integer'],

            'asset_model_id' => ['nullable', 'integer'],

            'supplier_id' => ['nullable', 'integer'],

            'asset_tag' => ['nullable', 'string', 'max:100'],

            'serial_number' => ['nullable', 'string', 'max:255'],

            'purchase_cost' => ['nullable', 'numeric', 'min:0'],

            'invoice_number' => ['nullable', 'string', 'max:100'],

            'purchase_date' => ['nullable', 'date'],

            'warranty_expiration_date' => [
                'nullable',
                'date',
                'after_or_equal:purchase_date',
            ],

            'criticality' => [
                'nullable',
                Rule::enum(AssetCriticality::class),
            ],

            'business_service' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    public function toDto(): CreateAssetDTO
    {
        return CreateAssetDTO::fromArray(
            $this->validated()
        );
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Asset name is required.',
            'asset_category_id.required' => 'Asset category is required.',
            'asset_status_id.required' => 'Asset status is required.',
            'warranty_expiration_date.after_or_equal'
                => 'Warranty date must be after purchase date.',
        ];
    }
}
