<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Services\StoreService;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;

class StoreController extends Controller
{
    public function __construct(protected StoreService $storeService)
    {
        $this->middleware('role:merchant')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $stores = $this->storeService->all();
        return $this->successResponse('Stores fetched successfully', StoreResource::collection($stores));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $store = $this->storeService->create($data);
        return $this->successResponse('Store created successfully', new StoreResource($store->load('merchant')));
    }

    public function show(Store $store)
    {
        return $this->successResponse('Store fetched successfully', new StoreResource($store));
    }

    public function update(StoreRequest $request, Store $store)
    {
        $store = $this->storeService->update($store, $request->validated());
        if (!$store) {
            return $this->errorResponse('You are not authorized to update this store', 403);
        }
        return $this->successResponse('Store updated successfully', new StoreResource($store));
    }

    public function destroy(Store $store)
    {
        $store = $this->storeService->delete($store);
        if (!$store) {
            return $this->errorResponse('You are not authorized to delete this store', 403);
        }
        return $this->successResponse('Store deleted successfully');
    }
}
