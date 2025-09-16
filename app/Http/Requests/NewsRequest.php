<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    private $table = 'news';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $conditionTitle     = "bail|required|unique:$this->table,title";
        if(!empty($this->id)){
            $conditionTitle     .= ",$this->id";
        }
        return [
            'title'      => $conditionTitle,
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
