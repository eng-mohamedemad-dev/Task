<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'items' => 'sometimes|required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'session_state' => 'required|string|max:100',
            'description' => 'sometimes|required|string|max:255',
            'store_id' => 'required|exists:stores,id',
        ];
    }
}
