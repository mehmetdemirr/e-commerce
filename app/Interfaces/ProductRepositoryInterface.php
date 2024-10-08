<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function all($page, $perPage);
    public function getProductsByBusinessId($businessId, $page = 1, $perPage = 10);
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
}
