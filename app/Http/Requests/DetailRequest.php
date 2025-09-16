<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
{
    private $table = 'detail';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        
        return [
            'style'         => 'bail|required|not_in:0',
            'color'         => 'bail|required|not_in:0',
            
        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function attributes()
    {
        return [
            'style'         => '<u><b>Style</b></u>',
            'color'         => '<u><b>Color</b></u>',
        ];
    }
}
