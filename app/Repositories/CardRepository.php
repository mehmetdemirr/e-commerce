<?php

namespace App\Repositories;

use App\Interfaces\CardRepositoryInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

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

    public function updateCartItemQuantity($itemId, $quantity)
    {
        $cartItem = CartItem::find($itemId);
        
        if ($cartItem) {
            $product = $cartItem->product;
            if ($product->quantity < $quantity) {
                //ürün adedi bu kadar yok
                return null;
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
            
            return $cartItem;
        }

        return null;
    }

    public function addItemToCart($cartId, $productId, $quantity)
    {
        $product = Product::find($productId);

        if (!$product || $product->quantity < $quantity) {
            return false;
        }

        $cart = Cart::find($cartId);
        return $cart->items()->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => $quantity]
        );
    }

    public function removeItemFromCart($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) 
        {
            $cartItem->delete();
            return true;
        }
        return false;
    }

    public function clearCart($cartId)
    {
        $cart = Cart::find($cartId);
        $cart->items()->delete();
    }
}
