<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\UpdateOrderStRequest;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
        $this->middleware('auth:sanctum')->except(['store','show','update','index']);
    }

    public function index()
    {
        $orders = $this->orderService->all();
        return $this->successResponse('Orders fetched successfully', OrderResource::collection($orders));
    }

    public function store(OrderRequest $request)
    {
        
        $order = $this->orderService->store($request->validated());
        return $this->successResponse('Order created successfully', new OrderResource($order));
    }

    public function show(Order $order)
    {
        $return_order = $this->orderService->show($order);

        if (!$return_order) {
            return $this->errorResponse('authorized', 404);
        }
        return $this->successResponse('Order fetched successfully', new OrderResource($return_order));
    }

    public function update(UpdateOrderStRequest $request, Order $order)
    {
        
        if ($order->user_id !== $order->user_id) {
            return $this->errorResponse('authorized', 404);
        }
        $updatedOrder = $this->orderService->updateOrder($order, $request->validated());
        return $this->successResponse('Order updated successfully', new OrderResource($updatedOrder));
    }

    public function destroy(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return $this->errorResponse('Order not found or not authorized', 404);
        }
        $return_order = $this->orderService->delete($order);
        return $this->successResponse('Order deleted successfully');
    }

}
