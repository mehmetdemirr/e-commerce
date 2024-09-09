<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function createOrder(int $userId);

    public function getOrdersByAuthenticatedUser(int $userId,int $page, int $perPage);

    public function getOrdersByUserId(int $userId,int $page, int $perPage);
    public function updateOrderStatus(int $orderId, string $newStatus);
    public function updatePaymentStatus(int $orderId, string $newPaymentStatus);
    public function getOrdersByBusinessId($businessId, $page = 1, $perPage = 10);
    public function getOrderById(int $orderId);
}
