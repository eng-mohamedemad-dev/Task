<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {
        $this->middleware('role:merchant')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $products = $this->productService->all();
        return $this->successResponse('Products fetched successfully', ProductResource::collection($products));
    }

    public function show(Product $product)
    {
        return $this->successResponse('Product fetched successfully', new ProductResource($product->load('user', 'store','category')));
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return $this->successResponse('Product created successfully', new ProductResource($product));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $updated_product = $this->productService->update($product, $request->validated());
        if ($updated_product) {
            return $this->successResponse('Product updated successfully', new ProductResource($updated_product->load('user', 'store')));
        }
        return $this->errorResponse('You do not have permission to update this product', 403);
    }

    public function destroy(Product $product)
    {
        $deleted_product = $this->productService->delete($product);
        if ($deleted_product) {
            return $this->successResponse('Product deleted successfully');
        }
        return $this->errorResponse('You do not have permission to delete this product', 403);
    }
}
