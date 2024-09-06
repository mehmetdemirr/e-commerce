<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function createOrder(int $userId);

    public function getOrdersByAuthenticatedUser(int $userId);

    public function getOrdersByUserId(int $userId);
    public function updateOrder(int $orderId, array $data);
}
