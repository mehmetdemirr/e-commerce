<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function all($page = 1,$perPage = 10)
    {
        //burda alt alta kategori olacaksa parent id null olanları getirmesin dedim 
        // return $this->model->with('children.children')->whereNull("parent_id")->paginate($perPage, ['*'], 'page', $page);
        return $this->model->with('children.children')->paginate($perPage, ['*'], 'page', $page);
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
