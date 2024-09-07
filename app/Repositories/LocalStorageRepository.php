<?php

namespace App\Repositories;
use App\Interfaces\StorageRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class LocalStorageRepository implements StorageRepositoryInterface
{
    /**
     * Store a file in the given path.
     *
     * @param string $path
     * @param mixed $file
     * @return string
     */
    public function store($path, $file)
    {
        // Save file to 'public' disk
        $filePath = Storage::disk('public')->put($path, $file);
        return $filePath; // Return the relative path of the file
    }

    /**
     * Retrieve a file from the given path.
     *
     * @param string $path
     * @return mixed
     */
    public function get($path)
    {
        // Retrieve file from 'public' disk
        return Storage::disk('public')->get($path);
    }

    /**
     * Delete a file from the given path.
     *
     * @param string $path
     * @return bool
     */
    public function delete($path)
    {
        // Ensure the path is correct by checking if it starts with 'public/'
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}
