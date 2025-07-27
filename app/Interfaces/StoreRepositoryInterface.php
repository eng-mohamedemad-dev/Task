<?php

namespace App\Interfaces;

interface StoreRepositoryInterface
{
    public function create(array $data);
    public function update($store, array $data);
    public function delete($store);
    public function find($id);
    public function all();
    public function getStoreByCharacterId($character_id);
}
