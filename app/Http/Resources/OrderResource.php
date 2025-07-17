<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'grand_total' => $this->grand_total,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'status' => $this->status,
            'session_state' => $this->session_state,
            'description' => $this->description,
            'store_id' => $this->store_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
