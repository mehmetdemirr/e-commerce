<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Policies\OrderPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function create(Request $request)
    {
        Gate::authorize("create", Order::class);

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
                    'message' => 'Sipariş başarılı şekilde oluştu.'
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
                'errors' => 'Sipariş oluştulamadı',
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

        Gate::authorize('update', $order);

        return response()->json([
            'success' => true,
            'data' => $order,
            'errors' => null,
            'message' => 'Order updated successfully.'
        ], 200);
    }

    public function getOrdersByAuthenticatedUser(Request $request)
    {
        Gate::authorize('viewAny', Order::class); 

        $userId = $request->user()->id;
        $page = $request->input('page', 1); 
        $perPage = $request->input('per_page', 15); 
        $orders = $this->orderRepository->getOrdersByAuthenticatedUser($userId,$page, $perPage);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
    }

    public function getOrdersByUserId(Request $request,$userId)
    {
        Gate::authorize('viewAnyAdmin', Order::class);

        $page = $request->input('page', 1); 
        $perPage = $request->input('per_page', 15); 
        $orders = $this->orderRepository->getOrdersByUserId($userId,$page, $perPage);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
    }
}
