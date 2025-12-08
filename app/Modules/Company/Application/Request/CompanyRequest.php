<?php

namespace App\Modules\Company\Application\Request;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'logo_path' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'min:3', 'max:96'],
            'city' => ['required', 'min:3', 'max:32'],
            'state' => ['required', 'min:3', 'max:32'],
            'city' => ['required', 'min:3', 'max:32'],
            'postal_code' => ['required', 'digits:5'],
            'is_active'   => ['nullable','boolean'],

        ];
        if ($this->isMethod('post')) {
            $rules += [
                'name' => ['required', 'min:3', 'max:32', 'unique:companies'],
                'tax_id' => ['required',  'min:3', 'max:64', 'unique:companies,tax_id'],
            ];
        } else {
            $id = $this->route('company') ?? $this->route('id');
            $rules += [
                'name' => ["required", "min:3", "max:32", "unique:companies,id,{$id}" ],
                'tax_id' => ["required",  "min:3", "max:64", "unique:companies,tax_id,{$id}" ],
            ];
        }

        return $rules;
    }
}
