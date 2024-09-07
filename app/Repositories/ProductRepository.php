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

    public function all($page = 1, $perPage = 10)
    {
        return $this->model->with(['images' => function ($query) {
            $query->where('is_main', true); // Filter for the main image
        }])
        ->paginate($perPage, ['*'], 'page', $page); // Use Laravel's paginate method
    }

    public function find($id)
    {
        return $this->model->with('images')->find($id);
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
