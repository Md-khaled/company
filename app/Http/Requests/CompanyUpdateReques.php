<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateReques extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'custom_fields.*.field_name' => 'required|string|max:255',
            'custom_fields.*.field_type' => 'required|string|max:255',
            'custom_fields.*.field_value' => 'required|string|max:255',
        ];
    }
}
