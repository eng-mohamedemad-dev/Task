<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $product = $this->route('product');
            if (!$product) {
                $validator->errors()->add('id', 'Product not found.');
            } elseif ($product->user_id !== auth()->id()) {
                $validator->errors()->add('user', 'You do not have permission to update this product.');
            }
        });
    }
}
