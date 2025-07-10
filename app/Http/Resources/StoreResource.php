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

        return [
            'store_id' => $this->id,
            'store_name' => $this->name,
            'merchant' => [
                'name' => $this->merchant->name ?? null,
                'email' => $this->merchant->email ?? null,
            ],
        ];
    }
}
