<?php

namespace App\Repositories;

use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    protected $model;

    public function __construct(ProductImage $productImage)
    {
        $this->model = $productImage;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $productImage = $this->find($id);
        $productImage->update($attributes);
        return $productImage;
    }

    public function delete($id)
    {
        $productImage = $this->find($id);
        $productImage->delete();
    }
}
