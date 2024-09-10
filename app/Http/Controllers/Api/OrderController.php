<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Requests\UpdatePaymentStatusRequest;
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

    public function updateOrderStatus(UpdateOrderStatusRequest $request,int $orderId)
    {
        $data = $request->validated();
        $order = $this->orderRepository->getOrderById($orderId);
        if(!$order){
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Order not found.',
                'message' => null
            ], 400);
        }
        
        Gate::authorize('updateOrderStatus', $order);

        $order = $this->orderRepository->updateOrderStatus($orderId, $data['order_status']);

        return response()->json([
            'success' => true,
            'data' => $order,
            'errors' => null,
            'message' => 'Order status updated successfully.'
        ], 200);
    }

    public function updatePaymentStatus(UpdatePaymentStatusRequest $request, $orderId)
    {
        $data = $request->validated();
        $order = $this->orderRepository->getOrderById($orderId);
        if(!$order){
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Order not found.',
                'message' => null
            ], 400);
        }

        Gate::authorize('updatePaymentStatus', $order);

        $order = $this->orderRepository->updatePaymentStatus($orderId, $data['payment_status']);

        return response()->json([
            'success' => true,
            'data' => $order,
            'errors' => null,
            'message' => 'Payment status updated successfully.'
        ], 200);
    }

    public function getOrdersByBusinessId(Request $request)
    {
        // Yetki kontrolü, uygun olanı ekleyin
        Gate::authorize('viewAnyCompany', Order::class);
        $businessId = $request->user()->business->id;
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);
        $orders = $this->orderRepository->getOrdersByBusinessId($businessId, $page, $perPage);

        return response()->json([
            'success' => true,
            'data' => $orders,
            'errors' => null,
            'message' => null
        ]);
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
