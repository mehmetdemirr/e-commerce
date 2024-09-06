<?php

namespace App\Repositories;

use App\Interfaces\StatusRepositoryInterface;
use App\Models\OrderStatus;

class OrdertStatusRepository implements StatusRepositoryInterface
{
    public function getAllStatuses()
    {
        return OrderStatus::all();
    }

    public function getStatusById(int $id)
    {
        $status = OrderStatus::find($id);
        if ($status) {
            return $status;
        }
        return false;
    }

    public function createStatus(array $data)
    {
        return OrderStatus::create($data);
    }

    public function updateStatus(int $id, array $data)
    {
        $status = $this->getStatusById($id);
        if ($status) {
            $status->update($data);
            return $status;
        }
        return false;
    }

    public function deleteStatus(int $id)
    {
        $status = $this->getStatusById($id);
        if ($status) {
            $status->delete();
            return true;
        }
        return false;
    }
}
