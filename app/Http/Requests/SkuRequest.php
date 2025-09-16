<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkuRequest extends FormRequest
{
    private $table = 'sku';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'style'      => 'bail|required',
            // 'color'      => 'bail|required',
            // 'size'       => 'bail|required',
            // 'quantity'   => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            //'name.required' => 'Name is required',
            
        ];
    }

    public function attributes()
    {
        return [
            //'name' => 'Tên',
            
        ];
    }
}
