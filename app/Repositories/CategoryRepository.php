<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function allByStore(string $storeId)
    {
        return Category::where('store_id', $storeId)->get();
    }

    public function find(string $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): ?Category
    {
        if ($category->store->user_id !== auth()->id()) {
            return null;
        }
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        if ($category->store->user_id !== auth()->id()) {
            return false;
        }
        return (bool) $category->delete();
    }
}


