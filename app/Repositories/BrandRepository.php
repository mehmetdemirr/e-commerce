<?php

namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->model = $brand;
    }

    public function all($page = 1,$perPage = 10)
    {
        return $this->model->paginate($perPage, ['*'], 'page', $page);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $brand = $this->model->find($id);
        if ($brand) {
            $brand->update($data);
            return $brand;
        }
        return null;
    }

    public function delete($id)
    {
        $brand = $this->find($id);
        if($brand != null)
        {
            $brand->delete();
            return true;
        }
        return false;
    }
}
