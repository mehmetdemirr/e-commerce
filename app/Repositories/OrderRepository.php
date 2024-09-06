<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderRepository implements OrderRepositoryInterface
{

    public function createOrder($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) 
        {
            return null;
        }
        $cartItems = $cart->items; // Sepetteki ürünleri al
        $total = 0;
        $ordersByBusiness = [];

        // Sepet ürünlerini mağazalara göre grupla
        foreach ($cartItems as $item) {
            $product = $item->product; // Ürünün detayları
            $businessId = $product->business_id; // Ürünün ait olduğu mağaza

            if (!isset($ordersByBusiness[$businessId])) {
                $ordersByBusiness[$businessId] = [
                    'total' => 0,
                    'items' => []
                ];
            }

            $ordersByBusiness[$businessId]['total'] += $item->quantity * $product->price;
            $ordersByBusiness[$businessId]['items'][] = $item;
        }

        $orders = [];

        // Her mağaza için bir sipariş oluştur
        foreach ($ordersByBusiness as $businessId => $data) {
            $order = Order::create([
                'user_id' => $userId,
                'business_id' => $businessId,
                'status' => 'pending',
                'total' => $data['total']
            ]);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $orders[] = $order;
        }

        return $orders;
    }

    public function getOrdersByAuthenticatedUser($userId)
    {
        return Order::where('user_id', $userId)->with('items.product')->get();
    }

    public function getOrdersByUserId($userId)
    {
        return Order::where('user_id', $userId)->with('items.product')->get();
    }
}
