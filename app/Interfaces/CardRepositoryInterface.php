<?php

namespace App\Interfaces;

interface CardRepositoryInterface
{
    public function getCartByUser($userId);

    public function createCart($userId); // Yeni Cart oluşturma

    public function addItemToCart($cartId, $productId, $quantity);

    public function removeItemFromCart($cartItemId);

    public function clearCart($cartId);
    public function updateCartItemQuantity($itemId, $quantity);
}
