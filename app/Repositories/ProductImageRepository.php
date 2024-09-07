<?php

namespace App\Repositories;

use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;


class ProductImageRepository implements ProductImageRepositoryInterface
{
    protected $model;
    protected $storageRepository;

    public function __construct(ProductImage $productImage,LocalStorageRepository $storageRepository)
    {
        $this->model = $productImage;
        $this->storageRepository = $storageRepository;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        try {
            $productImage = $this->model->find($id);    
    
            if (!$productImage) {
                return null;
            }
            return $productImage;
    
        } catch (\Exception $e) {
            return null;
        }
    }

    public function create(array $attributes)
    {
        // Dosyayı depolama
        $attributes['image_url'] = $this->storageRepository->store('product_images', $attributes['file']);
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $productImage = $this->find($id);
        if ($productImage) {
            // Eski dosyayı silme
            if (isset($attributes['file'])) {
                $this->storageRepository->delete($productImage->image_url);
                // Yeni dosyayı depolama
                $attributes['image_url'] = $this->storageRepository->store('product_images', $attributes['file']);
            }
            $productImage->update($attributes);
        }
        return $productImage;
    }

    public function delete($id)
    {
        try {
            $productImage = $this->find($id);
            if ($productImage) {
                // Dosyayı silme
                $filePath = $productImage->file_path;
                $this->storageRepository->delete($filePath);
                $productImage->delete();
                return true;
            }
            return false;
    
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findExistingMainImages($productId)
    {
        return $this->model->where('product_id', $productId)
                            ->where('is_main', true)
                            ->get();
    }
}
