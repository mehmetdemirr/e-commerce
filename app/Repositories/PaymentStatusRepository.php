<?php

namespace App\Repositories;

use App\Interfaces\StatusRepositoryInterface;
use App\Models\PaymentStatus;

class PaymentStatusRepository implements StatusRepositoryInterface
{
   /**
     * Get all payment statuses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStatuses()
    {
        return PaymentStatus::all();
    }

    /**
     * Get a specific payment status by ID.
     *
     * @param int $id
     * @return \App\Models\PaymentStatus|null
     */
    public function getStatusById(int $id)
    {
        $status =PaymentStatus::find($id);
        if ($status) {
            return $status;
        }
        return false;
    }

    /**
     * Create a new payment status.
     *
     * @param array $data
     * @return \App\Models\PaymentStatus
     */
    public function createStatus(array $data)
    {
        return PaymentStatus::create($data);
    }

    /**
     * Update an existing payment status by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\PaymentStatus
     */
    public function updateStatus(int $id, array $data)
    {
        $status = $this->getStatusById($id);
        if ($status) {
            $status->update($data);
            return $status;
        }
        return false;
    }

    /**
     * Delete a payment status by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteStatus(int $id)
    {
        $status = $this->getStatusById($id);
        if ($status) {
            return $status->delete();
        }
        return false;
    }
}
