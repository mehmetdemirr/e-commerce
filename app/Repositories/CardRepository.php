<?php

namespace App\Repositories;

use App\Interfaces\CardRepositoryInterface;
use App\Models\Cart;
use App\Models\CartItem;

class CardRepository implements CardRepositoryInterface
{
    public function getCartByUser($userId)
    {
        return Cart::where('user_id', $userId)->with('items.product')->first();
    }

    public function createCart($userId)
    {
        return Cart::create(['user_id' => $userId]);
    }

    public function addItemToCart($cartId, $productId, $quantity)
    {
        $cart = Cart::find($cartId);
        return $cart->items()->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => $quantity]
        );
    }

    public function removeItemFromCart($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();
    }

    public function clearCart($cartId)
    {
        $cart = Cart::find($cartId);
        $cart->items()->delete();
    }
}
