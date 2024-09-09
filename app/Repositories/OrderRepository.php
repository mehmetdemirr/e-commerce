<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * Create an order based on the cart of a user.
     *
     * @param int $userId
     * @return array|null
     */
    public function createOrder($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return null; // Sepet bulunamadı
        }

        $cartItems = $cart->items; // Sepetteki ürünleri al
        $ordersByBusiness = [];

        // Sepet ürünlerini mağazalara göre grupla
        foreach ($cartItems as $item) {
            $product = $item->product; // Ürünün detayları
            $businessId = $product->business_id; // Ürünün ait olduğu mağaza

            // Stok kontrolü
            if ($product->quantity < $item->quantity) {
                // Remove out-of-stock items from the cart
                $item->delete();
               return null;
            }

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
                'order_status_id' => 1, 
                'payment_status_id' => 1,
                'total' => $data['total'],
                'payment_method' => 'credit_card', // Varsayılan ödeme yöntemi
                'payment_reference' => null, // Varsayılan ödeme referansı
            ]);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                //Ürün stok azalt
                $item->product->decrement('quantity', $item->quantity);
            }

            $orders[] = $order;
        }

        // Sepet öğelerini sil
        $cart->items()->delete();

        return $orders;
    }

    /**
     * Update an existing order.
     *
     * @param int $orderId
     * @param array $data
     * @return \App\Models\Order|bool
     */
    public function updateOrder(int $orderId, array $data)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return false; // Sipariş bulunamadı
        }

        // Sipariş verilerini güncelle
        $order->update($data);

        return $order;
    }

    /**
     * Get orders by business ID.
     *
     * @param int $businessId
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getOrdersByBusinessId($businessId, $page = 1, $perPage = 10)
    {
        return Order::where('business_id', $businessId)
            ->with('items.product', 'orderStatus', 'paymentStatus')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getOrdersByAuthenticatedUser($userId, $page = 1, $perPage = 10)
    {
        return Order::where('user_id', $userId)
            ->with('items.product', 'orderStatus', 'paymentStatus')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getOrdersByUserId($userId, $page = 1, $perPage = 10)
    {
        return Order::where('user_id', $userId)
            ->with('items.product', 'orderStatus', 'paymentStatus')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
