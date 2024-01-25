<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer',
            'min_qty' => 'nullable|numeric|min:1',
            'product_id' => 'nullable|unique:item_infos,id',
            'name' => 'required|string|unique:item_infos,name',
            'name_bangla' => 'nullable',
            'published_price' => 'required|numeric',
            'sell_price' => 'nullable|numeric',
            'published' => 'nullable|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable',
            'discount_type' => 'nullable|integer',
            'current_stock' => 'required|integer',
            'images' => 'nullable',
            'thumbnail' => 'nullable|numeric',
            'status' => 'nullable',
            'stock_status' => 'nullable',
            'sub_title' => 'nullable|string',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'The English name is required.',
            'name.max' => 'The English name should not exceed 255 characters.',
            'name_bangla.required' => 'The Bangla name is required.',
            'name_bangla.max' => 'The Bangla name should not exceed 255 characters.',
            'current_stock.exists' => 'The Current_stock is required.',
        ];
    }
}
