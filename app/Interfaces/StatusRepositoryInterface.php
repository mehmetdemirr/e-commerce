<?php

namespace App\Interfaces;

interface StatusRepositoryInterface
{
    public function getAllStatuses();

    public function getStatusById(int $id);

    public function createStatus(array $data);

    public function updateStatus(int $id, array $data);

    public function deleteStatus(int $id);

}
