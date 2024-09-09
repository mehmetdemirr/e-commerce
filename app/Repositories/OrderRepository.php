<?php

namespace App\Repositories;

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
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
     * Update the status of an existing order.
     *
     * @param int $orderId
     * @param string $newStatus
     * @return \App\Models\Order|bool
     */
    public function updateOrderStatus(int $orderId, string $newStatus)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return false; // Order not found
        }

        $currentStatus = OrderStatusEnum::fromString($order->order_status);
        $newStatusEnum = OrderStatusEnum::fromString($newStatus);

        if (!OrderStatusEnum::canUpdateStatus($currentStatus, $newStatusEnum)) {
            return false; // Status update not allowed
        }

        // Update the order status
        $order->order_status = $newStatus;
        $order->save();

        return $order;
    }

    /**
     * Update the payment status of an existing order.
     *
     * @param int $orderId
     * @param string $newPaymentStatus
     * @return \App\Models\Order|bool
     */
    public function updatePaymentStatus(int $orderId, string $newPaymentStatus)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return false; // Order not found
        }

        $currentPaymentStatus = PaymentStatusEnum::fromString($order->payment_status);
        $newPaymentStatusEnum = PaymentStatusEnum::fromString($newPaymentStatus);

        if (!PaymentStatusEnum::canUpdateStatus($currentPaymentStatus, $newPaymentStatusEnum)) {
            return false; // Payment status update not allowed
        }

        // Update the payment status
        $order->payment_status = $newPaymentStatus;
        $order->save();

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

    /**
     * Get an order by its ID.
     *
     * @param int $orderId
     * @return \App\Models\Order|null
     */
    public function getOrderById(int $orderId)
    {
        $order = Order::find($orderId);
        return $order;
    }
}
