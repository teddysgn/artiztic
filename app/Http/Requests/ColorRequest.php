<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    private $table = 'color';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $conditionName     = "bail|required|unique:$this->table,name";
        if(!empty($this->id)){
            $conditionName     .= ",$this->id";
        }
        return [
            'name'      => $conditionName,
            'status'    => 'bail|in:active,inactive',
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
            //'name' => 'Tên',
            
        ];
    }
}
