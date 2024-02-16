<?php

namespace App\Http\Requests\Api;

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
        return [
            'name' => 'required|min:3|max:255',
            'age' => 'required|numeric|min:1|max:99',
            'country'=>'required|string',
            'email'=> 'required|email',
            'salary'=> 'required|numeric|min:1|max:100000',
            'position' =>'required|string',
        ];
    }
}
