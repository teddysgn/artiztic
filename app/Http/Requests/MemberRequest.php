<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    private $table = 'member';
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
            'min'       => 'bail|required',
            'discount'  => 'bail|required',
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
