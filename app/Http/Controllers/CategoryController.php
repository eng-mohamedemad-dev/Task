<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:merchant')->only(['store', 'update', 'destroy']);
    }

    public function index(Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return $this->errorResponse('You are not authorized to view categories for this store', 403);
        }
        $categories = $this->categoryService->allByStore($store->id);
        return $this->successResponse('Categories fetched successfully', CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request, Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return $this->errorResponse('You are not authorized to create a category for this store', 403);
        }
        $data = $request->validated();
        $data['store_id'] = $store->id;
        $category = $this->categoryService->create($data);
        return $this->successResponse('Category created successfully', new CategoryResource($category));
    }

    public function update(CategoryRequest $request, Store $store, Category $category)
    {
        if ($store->user_id !== auth()->id()) {
            return $this->errorResponse('You are not authorized to update a category for this store', 403);
        }
        if ($category->store_id !== $store->id) {
            return $this->errorResponse('Category does not belong to this store', 422);
        }
        $category = $this->categoryService->update($category, $request->validated());
        if (!$category) {
            return $this->errorResponse('You are not authorized to update this category', 403);
        }
        return $this->successResponse('Category updated successfully', new CategoryResource($category));
    }

    public function destroy(Store $store, Category $category)
    {
        if ($store->user_id !== auth()->id()) {
            return $this->errorResponse('You are not authorized to delete a category for this store', 403);
        }
        if ($category->store_id !== $store->id) {
            return $this->errorResponse('Category does not belong to this store', 422);
        }
        $deleted = $this->categoryService->delete($category);
        if (!$deleted) {
            return $this->errorResponse('You are not authorized to delete this category', 403);
        }
        return $this->successResponse('Category deleted successfully');
    }
}


