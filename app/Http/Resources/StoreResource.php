<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\map;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {

        return [
            'store_id' => $this->id,
            'store_name' => $this->name,
            'merchant' => [
                'name' => $this->merchant->name ?? null,
                'email' => $this->merchant->email ?? null,
            ],
            'products'=>
                $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'description' => $product->description ?? 'No description',
                        'image_url' => $product->image_url ? asset('storage/' . $product->image_url) : null,
                        'created_at' => $product->created_at->diffForHumans(),
                    ];
                })
        ];
    }
}
