<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    private $table = 'product';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $conditionPicture1  = 'bail|required|image';
        $conditionName      = "bail|required|unique:$this->table,name";
        $conditionStyle     = "bail|required|unique:$this->table,style";
        if(!empty($this->id)){
            $conditionPicture1   = 'bail|image';
            $conditionName      .= ",$this->id";
            $conditionStyle     .= ",$this->id";
        }
        return [
            'name'          => $conditionName,
            'style'         => $conditionStyle,
            'status'        => 'bail|in:active,inactive',
            'type'          => 'bail|in:normal,featured',
            'price'         => 'bail|required|min:1',
            'category_id'   => 'bail|required|not_in:0',
            'occasion_id'   => 'bail|required|not_in:0',
            'collection_id' => 'bail|required|not_in:0',
            'waist'         => 'bail|required',
            'fabric'        => 'bail|required',
            'composition'   => 'bail|required',
            'care'          => 'bail|required',
            'description'   => 'bail|required',
            'color'         => 'bail|required',
            'size'          => 'bail|required',
            'picture1'      => $conditionPicture1,
            'picture2'      => 'bail|image',
            'picture3'      => 'bail|image',
            'picture4'      => 'bail|image',
            'picture5'      => 'bail|image',
            'picture6'      => 'bail|image',
            
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
            'category_id'   => '<u><b>Category</b></u>',
            'occasion_id'   => '<u><b>Occasion</b></u>',
            'collection_id' => '<u><b>Collection</b></u>',
            'name'          => '<u><b>Name</b></u>',
            'type'          => '<u><b>Type</b></u>',
            'style'         => '<u><b>Style</b></u>',
            'status'        => '<u><b>Status</b></u>',
            'quantity'      => '<u><b>Quantity</b></u>',
            'price'         => '<u><b>Price</b></u>',
            'waist'         => '<u><b>Waist</b></u>',
            'fabric'        => '<u><b>Fabric</b></u>',
            'composition'   => '<u><b>Composiition</b></u>',
            'care'          => '<u><b>Care</b></u>',
            'color'         => '<u><b>Color</b></u>',
            'size'          => '<u><b>Size</b></u>',
            'description'   => '<u><b>Description</b></u>',
            'picture1'      => '<u><b>Picture 1</b></u>',
            'picture2'      => '<u><b>Picture 2</b></u>',
            'picture3'      => '<u><b>Picture 3</b></u>',
            'picture4'      => '<u><b>Picture 4</b></u>',
            'picture5'      => '<u><b>Picture 5</b></u>',
            'picture6'      => '<u><b>Picture 6</b></u>',
        ];
    }
}
