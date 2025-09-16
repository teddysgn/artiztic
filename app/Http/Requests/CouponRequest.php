<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    private $table = 'coupon';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $conditionQuantity = '';
        $conditionCode     = "bail|required|unique:$this->table,code";
        if(!empty($this->id)){
            $conditionCode     .= ",$this->id";
        }

        if($this->task == 'generate'){
            $conditionQuantity  = 'bail|required';
        }

        if($this->task == 'add'){
            return [
                'name'      => 'bail|required',
                'code'      => $conditionCode,
                'value'     => 'bail|required',
                'status'    => 'bail|in:active,inactive',
                'expired'   => 'bail|required',
            ];
        } else if($this->task == 'generate'){
            return [
                'quantity_multiple'  => $conditionQuantity,
                'value_multiple'     => 'bail|required',
                'expired_multiple'   => 'bail|required',
                'status_multiple'    => 'bail|in:active,inactive',
            ];
        }
        
    }

    public function messages()
    {
        return [
            'quantity_multiple.required'    => 'Quantity is required',
            'value_multiple.required'       => 'Value is required',
            
            
        ];
    }

    public function attributes()
    {
        return [
            'status_multiple'               => 'Status',
            
        ];
    }
}
