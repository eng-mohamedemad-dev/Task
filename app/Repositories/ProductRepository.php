<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::with('user', 'store')->where('user_id',auth()->id())->get();
    }
    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        if ($product->user_id !== auth()->id()) {
            return null;
        }
        return tap($product, function ($product) use ($data) {
            $product->update($data);
        });
    }

    public function delete(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return false;
        }
        return $product->delete();
    }
}
