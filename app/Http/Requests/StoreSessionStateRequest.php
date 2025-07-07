<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreSessionStateRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'session_id' => 'required|uuid',
            'restaurant_name' => 'nullable|string|max:255',
            'current_step' => 'required|string|max:255',
            'temp_product_name' => 'nullable|string|max:255',
            'temp_quantity' => 'nullable|integer|min:1',
            'last_chosen_product_id' => 'nullable|exists:products,id',
            'interaction_history' => 'nullable|array',
            'last_interaction' => 'nullable|date',
        ];
    }
}
