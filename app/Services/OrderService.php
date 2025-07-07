<?php

// app/Services/Order/OrderService.php
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
            'session_id' => $data['session_id'],
            'grand_total' => $grandTotal,
            'items' => $items,
        ];

        return $this->orderRepo->createOrder($finalData);
    }

    public function getOrderSummary(string $sessionId) {
        $order = $this->orderRepo->getOrderSummary($sessionId);
        return $order;
    }
}
