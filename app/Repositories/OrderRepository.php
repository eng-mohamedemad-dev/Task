<?php


namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create($data);
            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }

            return $order->load('items');
        });
    }

    public function showOrder($order)
    {
        $userId = auth()->id();
        return Order::with('items')->where([
            ['user_id', $userId],
            ['id', $order->id]
        ])->first();
    }

    public function deleteOrder($order)
    {
        $userId = auth()->id();
        $order = Order::where('id', $order->id)->where('user_id', $userId)->first();
        if ($order) {
            return $order->delete();
        }
    }

    public function getAllOrders()
    {
        $userId = auth()->id();
        return Order::where('user_id', $userId)->with('items')->get();
    }

    public function updateOrderStatus($order, string $status)
    {
        $order = Order::findOrFail($order->id);
        if ($order) {
            return tap($order, function ($order) use ($status) {
               return $order->update(['status' => $status]);
            });
        }
    }
}
