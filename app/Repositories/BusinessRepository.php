<?php

namespace App\Repositories;

use App\Interfaces\BusinessRepositoryInterface;
use App\Models\Business;

class BusinessRepository implements BusinessRepositoryInterface
{
    protected $model;

    public function __construct(Business $business)
    {
        $this->model = $business;
    }

    public function all($page = 1, $perPage = 10)
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $business = $this->find($id);
        if ($business) {
            $business->update($attributes);
            return $business;
        }
        return null;
    }

    public function delete($id)
    {
        $business = $this->find($id);
        if ($business) {
            $business->delete();
            return true;
        }
        return false;
    }
}
