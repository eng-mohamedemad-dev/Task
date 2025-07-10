<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function createOrder(array $data);
    public function showOrder($order);
    public function deleteOrder($order);
    public function getAllOrders();
    public function updateOrderStatus($order, string $status);
}

