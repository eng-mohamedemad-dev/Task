<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'price_per_unit' => $this->price_per_unit,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
        ];
    }
}
