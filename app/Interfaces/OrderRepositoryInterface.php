<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function createOrder(int $userId);

    public function getOrdersByAuthenticatedUser(int $userId,int $page, int $perPage);

    public function getOrdersByUserId(int $userId,int $page, int $perPage);
    public function updateOrder(int $orderId, array $data);
}
