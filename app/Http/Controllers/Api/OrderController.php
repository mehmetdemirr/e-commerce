<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => 'Orders created successfully.'
        ]);
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
        $this->authorize('viewAny', Order::class); // Yetkilendirme kontrolü
        $orders = $this->orderRepository->getOrdersByUserId($userId);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
    }
}
