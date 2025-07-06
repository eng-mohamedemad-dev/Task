<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}

    public function all()
    {
        return $this->productRepository->all();
    }

    public function create(array $data)
    {
        if (isset($data['image_url'])) {
            $data['image_url'] = Storage::disk('public')->put('products', $data['image_url']);
        }
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['image_url'])) {
            $this->deleteImage($product->image_url);
            $data['image_url'] = Storage::disk('public')->put('products', $data['image_url']);
        }
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product)
    {
        $this->deleteImage($product->image_url);
        return $this->productRepository->delete($product);
    }

    protected function deleteImage($imageUrl)
    {
        if ($imageUrl) {
            Storage::disk('public')->delete($imageUrl);
        }
    }
}
