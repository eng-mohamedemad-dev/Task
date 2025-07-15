<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
class UpdateOrderStRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'session_state' => 'required|string|max:100',
        ];
    }

}
