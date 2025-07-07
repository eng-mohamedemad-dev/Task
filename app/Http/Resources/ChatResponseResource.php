<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'session_id' => $this['session_id'],
            'response_text' => $this['response_text'],
            'next_step' => $this['next_step'],
            'current_order_summary' => [
                'id' => $this['current_order_summary']->id,
                'grand_total' => $this['current_order_summary']->grand_total,
                'items' => $this['current_order_summary']->items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'price_per_unit' => $item->price_per_unit,
                        'total_price' => $item->total_price,
                        'order_id' => $item->order_id,
                        'product_id' => $item->product_id,
                    ];
                }),
            ] ,
            'products_available' => $this['products_available'],
            'debug_info' => $this['debug_info'],
        ];
    }

}
