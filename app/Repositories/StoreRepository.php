<?php

namespace App\Repositories;

use App\Models\Store;
use App\Interfaces\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function create(array $data)
    {
        return Store::create($data);
    }

    public function update($store, array $data)
    {
        if ($store->user_id !== auth()->id()) {
            return null;
        }
        return tap($store, function ($store) use ($data) {
            return $store->update($data);
        });
    }

    public function delete($store)
    {
        if ($store->user_id !== auth()->id()) {
            return null;
        }
        return $store->delete();
    }

    public function find($id)
    {
        return Store::findOrFail($id);
    }

    public function all()
    {
        return Store::with('merchant', 'products')->where('user_id',auth()->id())->get();
    }

    public function getStoreByCharacterId($character_id)
    {
        return Store::with('products')->where('character_id', $character_id)->get();
    }
}
