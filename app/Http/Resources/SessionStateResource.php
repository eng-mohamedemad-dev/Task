<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionStateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'session_id' => $this->session_id,
            'restaurant_name' => $this->restaurant_name,
            'current_step' => $this->current_step,
            'temp_product_name' => $this->temp_product_name,
            'temp_quantity' => $this->temp_quantity,
            'interaction_history' => $this->interaction_history,
            'last_chosen_product_id' => $this->last_chosen_product_id,
            'last_interaction' => $this->last_interaction,
            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
        ];
    }
}
