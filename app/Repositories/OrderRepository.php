<?php


namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Store;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data)
    {
        $data['user_id'] = Store::with('merchant')->find($data['store_id'])->merchant->id;
        $data['status'] = 'pending';
        return DB::transaction(function () use ($data) {
            $order = Order::create($data);
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $order->items()->create($item);
                }
            }
            return $order->load('items');
        });
    }

    public function showOrder($order)
    {
        $userId = Store::with('merchant')->find($order->store_id)->merchant->id;
        return Order::with('items')->where([
            ['user_id', $userId],
            ['id', $order->id]
        ])->first();
    }

    public function deleteOrder($order)
    {
        $store =Store::with('merchant')->where('id',$order->store_id)->first();
        $userId= $store->merchant->id;
        $order = Order::where('id', $order->id)->where('user_id', $userId)->first();
        if ($order) {
            return $order->delete();
        }
    }

    public function getAllOrders()
    {
        return Order::with('items')->get();
    }

 public function updateOrder($order, array $data)
{
    return DB::transaction(function () use ($order, $data) {
        $grandTotal = 0;
        if (isset($data['items']) && is_array($data['items']) && count($data['items']) > 0) {
            $order->items()->delete();
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
        }
        if (isset($data['session_state'])) {
            $order->session_state = $data['session_state'];
        }
        if (isset($data['description'])) {
            $order->description = $data['description'];
        }
        if (isset($data['store_id'])) {
            $order->store_id = $data['store_id'];
        }
        $order->save();
        return $order->load('items');
    });
}

}
