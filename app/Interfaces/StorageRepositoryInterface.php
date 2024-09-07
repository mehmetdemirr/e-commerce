<?php

namespace App\Interfaces;

interface StorageRepositoryInterface
{
    public function store($path, $file);

    public function get($path);

    public function delete($path);
}
