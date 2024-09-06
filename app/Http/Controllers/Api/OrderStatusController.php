<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Repositories\OrdertStatusRepository;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    protected $statusRepository;

    public function __construct(OrdertStatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function index()
    {
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
        if ($status) {
            return response()->json([
                'success' => true,
                'data' => $status,
                'errors' => null,
                'message' => null,
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => 'Order status not found.',
            'message' => null,
        ], 400);
    }

    public function store(StatusRequest $request)
    {
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
        if ($this->statusRepository->deleteStatus($id)) {
            return response()->json([
                'success' => true,
                'data' => null,
                'errors' => null,
                'message' => 'Order status deleted successfully.',
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => 'Order status not found.',
            'message' => null,
        ], 400);
    }
}
