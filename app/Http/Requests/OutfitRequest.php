<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutfitRequest extends FormRequest
{
    private $table = 'outfit';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
           
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
