<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{

    use AuthorizesRequests;

    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function create(Request $request)
    {
        $userId = $request->user()->id;

        // Sepeti oluştur ve sipariş oluştur
        $orders = $this->orderRepository->createOrder($userId);

        // Verinin türünü kontrol edin
        if (is_array($orders) || $orders instanceof \Countable) {
            if (count($orders) > 0) {
                return response()->json([
                    'success' => true,
                    'data' => $orders,
                    'errors' => null,
                    'message' => 'Orders created successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'errors' => null,
                    'message' => 'Sipariş oluşturulamadı'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'İçsel hata',
                'message' => null
            ]);
        }
    }

    public function update(UpdateOrderRequest $request, $orderId)
    {
        $data = $request->validated();

        $order = $this->orderRepository->updateOrder($orderId, $data);

        if ($order === false) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Order not found.',
                'message' => null
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
            'errors' => null,
            'message' => 'Order updated successfully.'
        ], 200);
    }

    public function getOrdersByAuthenticatedUser(Request $request)
    {
        $userId = $request->user()->id;
        $orders = $this->orderRepository->getOrdersByAuthenticatedUser($userId);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
    }

    public function getOrdersByUserId($userId)
    {
        $this->authorize('viewAny', Order::class); 
        $orders = $this->orderRepository->getOrdersByUserId($userId);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
    }
}
