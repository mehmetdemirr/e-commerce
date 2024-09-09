<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\OrderStatus;
use App\Repositories\OrdertStatusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderStatusController extends Controller
{
    protected $statusRepository;

    public function __construct(OrdertStatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function index()
    {
        Gate::authorize('viewAny', OrderStatus::class);
        $statuses = $this->statusRepository->getAllStatuses();
        return response()->json([
            'success' => true,
            'data' => $statuses,
            'errors' => null,
            'message' => null,
        ]);
    }

    public function show($id)
    {
        $status = $this->statusRepository->getStatusById($id);
        if (!$status) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Order status not found.',
                'message' => null,
            ], 400);
        }

        Gate::authorize('view',$status);
        
        return response()->json([
            'success' => true,
            'data' => $status,
            'errors' => null,
            'message' => null,
        ]);
    }

    public function store(StatusRequest $request)
    {
        Gate::authorize('create', OrderStatus::class);
        $data = $request->validated();
        $status = $this->statusRepository->createStatus($data);
        return response()->json([
            'success' => true,
            'data' => $status,
            'errors' => null,
            'message' => 'Order status created successfully.',
        ], 200);
    }

    public function update(StatusRequest $request, $id)
    {
       
        $data = $request->validated();
        Gate::authorize('update', $request);
        $status = $this->statusRepository->updateStatus($id, $data);
        if ($status) {
            return response()->json([
                'success' => true,
                'data' => $status,
                'errors' => null,
                'message' => 'Order status updated successfully.',
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => 'Order status not found.',
            'message' => null,
        ], 400);
    }

    public function destroy($id)
    {
        $status = $this->statusRepository->getStatusById($id);
        if (!$status) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => "Status bulunamadı",
                'message' => null,
            ],400);
        }

        Gate::authorize('delete', $status);

        if ($this->statusRepository->deleteStatus($id)) {
            return response()->json([
                'success' => true,
                'data' => null,
                'errors' => null,
                'message' => 'Order status deleted successfully.',
            ],200);
        }

        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => 'Order status silinemedi.',
            'message' => null,
        ], 400);
    }
}
