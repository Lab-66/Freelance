<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'product_name' => "required",
            'sale_price' => "required|regex:/^\d{1,6}(\.\d{1,2})?$/",
            'quantity_on_hand' => "required|integer",
            'quantity_available' => "required|integer",
            'category_id' => "required",
            'product_image_file' => 'image|max:2000'
        ];
    }
}
