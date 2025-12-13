<?php

namespace App\Modules\Company\Application\Request;

use Illuminate\Foundation\Http\FormRequest;

class CompanyPositionRequest extends FormRequest
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
            'company_department_id' => ['required','exists:company_departments,id'],
            'position_template_id' => ['required','exists:position_templates,id'],
            'description' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules += [
                'name' => ['required', 'string', 'max:255'],
            ];
        } else if ($this->isMethod('patch')) {
            $rules += [
                'name' => ['sometimes', 'string', 'max:255'],
            ];
        }

        return $rules;
    }
}
