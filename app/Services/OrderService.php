<?php

namespace App\Services;

use App\Models\Product;
use App\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(protected OrderRepositoryInterface $orderRepo)
    {
    }

    public function store(array $data)
    {
        $items = [];
        $grandTotal = 0;
        if (isset($data['items'])) {
        foreach ($data['items'] as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);

            $totalPrice = $product->price * $itemData['quantity'];

            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price_per_unit' => $product->price,
                'quantity' => $itemData['quantity'],
                'total_price' => $totalPrice,
            ];

                $grandTotal += $totalPrice;
            }
        }

        $finalData = [
            'user_id' => auth()->id(),
            'session_state' => $data['session_state'],
            'grand_total' => $grandTotal,
            'items' => $items,
            'description' => $data['description'] ?? '',
            'store_id' => $data['store_id'],
        ];

        return $this->orderRepo->createOrder($finalData);
    }

    public function show($order)
    {
        return $this->orderRepo->showOrder($order);
    }


    public function delete($order)
    {
        return $this->orderRepo->deleteOrder($order);
    }

    public function all()
    {
        return $this->orderRepo->getAllOrders();
    }

    public function updateOrder($order, array $data)
    {
        $order = $this->orderRepo->updateOrder($order, $data);
        return $order;
    }
}
