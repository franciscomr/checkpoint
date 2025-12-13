<?php

namespace App\Modules\Company\Application\Request;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'branch_id' => 'required|exists:branches,id',
            'company_position_id' => 'required|exists:company_positions,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'hire_date' => 'required|date',
        ];
        if ($this->isMethod('post')) {
            $rules += [
                'name' => ['required', 'min:3', 'max:32', 'unique:employees'],
                'employee_code' => ['required',  'min:3', 'max:32', 'unique:employee,employee_code'],
                'email' => 'required|email|unique:employees,email',


            ];
        } else if ($this->isMethod('patch')) {
            $id = $this->route('employees') ?? $this->route('id');
            $rules += [
                'name' => ['required', 'min:3', 'max:32', 'unique:employees,name,' . $id],
                'employee_code' => ['required',  'min:3', 'max:32', 'unique:employees,employee_code'. $id],
                'email' => ['required',  'email', 'unique:employees,email'. $id],
            ];
        }

        return $rules;
    }
}
