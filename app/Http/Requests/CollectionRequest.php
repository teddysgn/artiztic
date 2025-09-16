<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
{
    private $table = 'collection';
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
