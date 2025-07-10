<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class StoreSessionStateRequest extends BaseRequest
{

    public function rules(): array
    {
        if ($this->isMethod('put')) {

            return [
                'session_id' => 'required|uuid|'. Rule::unique('session_states', 'session_id')->ignore($this->route('session'), 'session_id'),
                'restaurant_name' => 'nullable|string|max:255',
                'current_step' => 'required|string|max:255',
                'temp_product_name' => 'nullable|string|max:255',
                'temp_quantity' => 'nullable|integer|min:1',
                'last_chosen_product_id' => 'nullable|exists:products,id',
                'interaction_history' => 'nullable|array',
                'last_interaction' => 'nullable|date',
                'user_id' => 'required|exists:users,id',
            ];
        }
        return [
            'session_id' => 'required|uuid|unique:session_states,session_id',
            'restaurant_name' => 'nullable|string|max:255',
            'current_step' => 'required|string|max:255',
            'temp_product_name' => 'nullable|string|max:255',
            'temp_quantity' => 'nullable|integer|min:1',
            'last_chosen_product_id' => 'nullable|exists:products,id',
            'interaction_history' => 'nullable|array',
            'last_interaction' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
