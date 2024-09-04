<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function all($page = 1,$perPage = 10)
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
        $product = $this->find($id);
        if($product != null)
        {
            $product->update($attributes);
            return $product;
        }
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        if($product != null)
        {
            $product->delete();
            return true;
        }
        return false;
    }
}
