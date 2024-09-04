<?php

namespace App\Repositories;

use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    protected $model;

    public function __construct(ProductImage $productImage)
    {
        $this->model = $productImage;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        try {
            // ProductImage modelinden belirli bir ID'ye sahip resmi bul
            $productImage = $this->model->find($id);    
    
            // Eğer model bulunamazsa, uygun bir hata mesajı döndür
            if (!$productImage) {
                return null;
            }
            return $productImage;
    
        } catch (\Exception $e) {
            // Hata durumunda uygun bir yanıt döndür
            return null;
        }
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $productImage = $this->find($id);
        $productImage->update($attributes);
        return $productImage;
    }

    public function delete($id)
    {
        try {
            // ProductImage modelinden belirli bir ID'ye sahip resmi bul
            $productImage = $this->find($id);
    
            // Eğer model bulunamazsa, uygun bir hata mesajı döndür
            if (!$productImage) {
                return false;
            }
    
            // Modeli sil ve başarılı bir yanıt döndür
            $productImage->delete();
            return true;
    
        } catch (\Exception $e) {
            // Hata durumunda uygun bir yanıt döndür
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
