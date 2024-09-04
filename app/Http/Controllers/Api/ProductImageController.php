<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

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
        return response()->json([
            'success' => true,
            'data' => $productImage,
            'errors' => null,
            'message' => null
        ], 200);
    }

    public function store(StoreProductImageRequest $request)
    {
        $validatedData = $request->validated();

        // Start a database transaction
        DB::beginTransaction();

        try {
            $images = $validatedData['images'];
            $mainImages = array_filter($images, function ($image) {
                return isset($image['is_main']) && $image['is_main'];
            });

            if (count($mainImages) > 1) {
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
        $productImage = $this->productImageRepository->update($id, $validatedData);
        return response()->json([
            'success' => true,
            'data' => $productImage,
            'errors' => null,
            'message' => 'Product image updated successfully.'
        ], 200);
    }

    public function destroy($id)
    {
        $this->productImageRepository->delete($id);
        return response()->json([
            'success' => true,
            'data' => null,
            'errors' => null,
            'message' => 'Product image deleted successfully.'
        ], 204);
    }
}
