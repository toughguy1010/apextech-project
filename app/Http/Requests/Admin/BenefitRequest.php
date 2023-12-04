<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BenefitRequest extends FormRequest
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
            //
            'name' => 'required|string',
            'policy' => 'required|string',
        ];
        
    }
    public function messages()
    {
        return[
            'name.required' => 'Tên phúc lợi không được để trống',
            'policy.required' => 'Quy chế phúc lợi không được để trống',
        ];
    }
}
