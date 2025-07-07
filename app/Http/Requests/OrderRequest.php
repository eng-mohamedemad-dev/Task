<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'session_id' => 'required|uuid|exists:session_states,session_id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
