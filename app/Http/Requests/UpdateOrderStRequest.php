<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
class UpdateOrderStRequest extends BaseRequest
{
    public function rules()
    {
        return [
        'items' => 'sometimes|array|min:1',
        'items.*.product_id' => 'required_with:items.*|exists:products,id',
        'items.*.quantity' => 'required_with:items.*|integer|min:1',
        'description' => 'sometimes|required|string|max:255',
        'session_state' => 'sometimes|string|max:100',
        'store_id' => 'sometimes|required|exists:stores,id',
        ];
    }

}
