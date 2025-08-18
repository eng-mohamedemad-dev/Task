<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $user = auth()->user();
        if (!$user) {
            return [
                'store_id' => $this->id,
                'store_name' => $this->name,
                'character_id' => $this->character_id,
            'products'=>
            $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'description' => $product->description ?? 'No description',
                    'image_url' => $product->image_url ? asset('storage/' . $product->image_url) : null,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                    ] : null,
                    'created_at' => $product->created_at->diffForHumans(),
                ];
            })
        ];
                }
        return [
            'store_id' => $this->id,
            'store_name' => $this->name,
            'character_id' => $this->character_id,
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
                        'category' => $product->category ? [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                        ] : null,
                        'created_at' => $product->created_at->diffForHumans(),
                    ];
                })
        ];
    }
}
