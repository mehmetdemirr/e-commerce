<?php

namespace App\Interfaces;

interface BusinessRepositoryInterface
{
    public function all($page, $perPage);
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
}
