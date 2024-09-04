<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Interfaces\BrandRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request)
    {
         // Request'ten page ve perPage parametrelerini alıyoruz. 
         $page = $request->input('page', 1); 
         $perPage = $request->input('per_page', 15); 
 
        $brands = $this->brandRepository->all($page,$perPage);
        return response()->json([
            'success' => true,
            'data' => $brands,
            'errors' => null,
            'message' => null,
        ], 200);
    }

    public function show($id)
    {
        $brand = $this->brandRepository->find($id);
        if ($brand) {
            return response()->json([
                'success' => true,
                'data' => $brand,
                'errors' => null,
                'message' => null,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Brand not found.',
                'message' => 'The requested brand does not exist.',
            ], 400);
        }
    }

    public function store(StoreBrandRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $brand = $this->brandRepository->create($validatedData);
            return response()->json([
                'success' => true,
                'data' => $brand,
                'errors' => null,
                'message' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Failed to create the brand.',
            ], 400);
        }
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $validatedData = $request->validated();

        $brand = $this->brandRepository->update($id, $validatedData);
        if ($brand) 
        {
            return response()->json([
                'success' => true,
                'data' => $brand,
                'errors' => null,
                'message' => null,
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => null,
                'message' => 'brand bulunamadı.',
            ], 400);

        }

    }

    public function destroy($id)
    {
        $brand = $this->brandRepository->delete($id);
        if ($brand) {
           return response()->json([
                'success'=> true,
                'data' => null,
                'errors' => null,
                'message' => "Brand silindi !",
                ], 200
            );
        } else {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' =>  "Böyle bir brand bulunmamadı !",
                ], 400
            );
        }
    }
}
