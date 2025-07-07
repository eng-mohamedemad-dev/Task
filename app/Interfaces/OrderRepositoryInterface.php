<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function createOrder(array $data);
    public function getOrderSummary(string $sessionId);
}

