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

        $finalData = [
            'user_id' => auth()->id(),
            'grand_total' => $grandTotal,
            'items' => $items,
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

    public function updateOrderStatus($order, string $status)
    {
        return $this->orderRepo->updateOrderStatus($order, $status);
    }
}
