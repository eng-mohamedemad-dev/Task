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

    public function updateOrder($order, array $data)
    {
        return DB::transaction(function () use ($order, $data) {
            $order = Order::findOrFail($order->id);
            $order->items()->delete();
            $items = [];
            $grandTotal = 0;
            foreach ($data['items'] as $itemData) {
                $product = \App\Models\Product::findOrFail($itemData['product_id']);
                $totalPrice = $product->price * $itemData['quantity'];
                $item = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price_per_unit' => $product->price,
                    'quantity' => $itemData['quantity'],
                    'total_price' => $totalPrice,
                ];
                $order->items()->create($item);
                $grandTotal += $totalPrice;
            }
            $order->grand_total = $grandTotal;
            $order->session_state = $data['session_state'];
            $order->save();
            return $order->load('items');
        });
    }
}
