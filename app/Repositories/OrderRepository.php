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
            $order = Order::create([
                'session_id' => $data['session_id'],
                'grand_total' => $data['grand_total'],
            ]);
            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }

            return $order->load('items');
        });
    }

    public function getOrderSummary(string $sessionId)
    {
        return Order::where('session_id', $sessionId)->with('items')->first();
    }
}
