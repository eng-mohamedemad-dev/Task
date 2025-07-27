<?php

namespace App\Services;

use App\Interfaces\StoreRepositoryInterface;

class StoreService
{
    public function __construct(protected StoreRepositoryInterface $storeRepo)
    {
    }

    public function create(array $data)
    {
        return $this->storeRepo->create($data);
    }

    public function update($store, array $data)
    {
        return $this->storeRepo->update($store, $data);
    }

    public function delete($store)
    {
        return $this->storeRepo->delete($store);
    }

    public function find($id)
    {
        return $this->storeRepo->find($id);
    }

    public function all()
    {
        return $this->storeRepo->all();
    }

    public function getStoreByCharacterId($character_id)
    {
        return $this->storeRepo->getStoreByCharacterId($character_id);
    }
}
