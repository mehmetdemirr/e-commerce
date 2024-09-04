<?php

namespace App\Interfaces;

interface BrandRepositoryInterface
{
    public function all($page, $perPage);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
