<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    protected $productImageRepository;

    public function __construct(ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function index()
    {
        $productImages = $this->productImageRepository->all();
        return response()->json([
            'success' => true,
            'data' => $productImages,
            'errors' => null,
            'message' => null
        ], 200);
    }

    public function show($id)
    {
        $productImage = $this->productImageRepository->find($id);
        if ($productImage != null) 
        {
            return response()->json([
                'success' => true,
                'data' => $productImage,
                'errors' => null,
                'message' => null
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => null,
                'message' => "product image bulunamadı"
            ], 400);
        }
        
    }

    public function store(StoreProductImageRequest $request)
    {
        $validatedData = $request->validated();
        $product_id = $validatedData['product_id'];
        $images = $validatedData['images'];

        // Add product_id to each image
        foreach ($images as &$image) {
            $image['product_id'] = $product_id;
        }

        DB::beginTransaction();

        try {
            // Check for existing main images
            $existingMainImages = $this->productImageRepository->findExistingMainImages($product_id);
            $mainImages = array_filter($images, function ($image) {
                return isset($image['is_main']) && $image['is_main'];
            });


            if (count($existingMainImages) + count($mainImages) > 1) {
                throw new \Exception('Only one image can be marked as main.');
            }



            foreach ($images as $image) {
                $this->productImageRepository->create($image);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $images,
                'errors' => null,
                'message' => 'Product images created successfully.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
 
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => ['images' => [$e->getMessage()]],
                'message' => 'Failed to create product images.'
            ], 400);
        }
    }


    public function update(UpdateProductImageRequest $request, $id)
    {
        $validatedData = $request->validated();
        $images = $validatedData['images'];

        // Add product_id to each image
        foreach ($images as &$image) {
            $image['product_id'] = $id;
        }

        DB::beginTransaction();

        try {
            // Fetch existing images for the given product
            $existingImages = $this->productImageRepository->findExistingMainImages($id);
            $existingMainImages = $existingImages->where('is_main', true)->all();
            $mainImages = array_filter($images, function ($image) {
                return isset($image['is_main']) && $image['is_main'];
            });

            // Ensure only one main image
            if (count($existingMainImages) + count($mainImages) > 1) {
                throw new \Exception('Only one image can be marked as main.');
            }

            // Update existing images
            foreach ($images as $image) {
                // Find the existing image model
                $productImage = $this->productImageRepository->find($image["id"]);

                if (!$productImage) {
                    throw new \Exception('Image not found.');
                }
                // Update the model with new data
                $productImage->update($image);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $images,
                'errors' => null,
                'message' => 'Product images updated successfully.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => ['images' => [$e->getMessage()]],
                'message' => 'Failed to update product images.'
            ], 400);
        }
    }

    public function destroy($id)
    {
        $productImage = $this->productImageRepository->delete($id);
        if ($productImage) 
        {
            return response()->json([
                'success' => true,
                'data' => null,
                'errors' => null,
                'message' => "product image silindi"
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => null,
                'message' => "product image silinmedi !"
            ], 400);
        }
    }
}
