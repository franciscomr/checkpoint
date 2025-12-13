<?php

namespace App\Modules\Company\Application\Request;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentTemplateRequest extends FormRequest
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
            'description' => ['nullable', 'string', 'max:255'],
        ];
        if ($this->isMethod('post')) {
            $rules += [
                'name' => 'required|string|max:255|unique:department_templates,name',
            ];
        } else if ( $this->isMethod('put') ) {
            $id = $this->route('department_templates') ?? $this->route('id');
            $rules += [
            'name' => 'required|string|max:255|unique:department_templates,name,' . $id,
            ];
        }

        return $rules;
    }
}
