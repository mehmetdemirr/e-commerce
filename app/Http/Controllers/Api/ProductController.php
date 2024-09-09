<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        Gate::authorize("viewAny", Product::class);
        // Request'ten page ve perPage parametrelerini alıyoruz. 
        $page = $request->input('page', 1); 
        $perPage = $request->input('per_page', 15); 

        // Repository'nin all metoduna page ve perPage değerlerini gönderiyoruz.
        $products = $this->productRepository->all($page,$perPage);
        return response()->json([
            'success'=> true,
            'data' => $products,
            'errors' => null,
            'message' =>  null,
            ], 200
        );
    }

    /**
     * Get products by business ID
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductsByBusiness(Request $request)
    {
        Gate::authorize('viewAnyCompany', Product::class);
        $businessId = $request->user()->business->id;
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);

        $products = $this->productRepository->getProductsByBusinessId($businessId, $page, $perPage);
        return response()->json([
            'success' => true,
            'data' => $products,
            'errors' => null,
            'message' => null,
        ], 200);
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        if(!$product)
        {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' => "Böyle bir product bulunamadı !",
                ], 400
            );
        }

        Gate::authorize("view", $product);

        return response()->json([
            'success'=> true,
            'data' => $product,
            'errors' => null,
            'message' =>  null,
            ], 200
        );
    }

    public function store(StoreProductRequest $request)
    {
        Gate::authorize("create", Product::class);
        $validatedData = $request->validated();
        $validatedData['business_id'] = $request->user()->business->id;
                        
        $product = $this->productRepository->create($validatedData);
        return response()->json([
            'success'=> true,
            'data' => $product,
            'errors' => null,
            'message' =>  null,
            ], 200
        );
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $validatedData = $request->validated();

        $product = $this->productRepository->find($id);
        if(!$product)
        {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' => "Böyle bir product bulunamadı !",
                ], 400
            );
        }
        Gate::authorize("update", $product);

        $product = $this->productRepository->update($id, $validatedData);
        if ($product) {
            return response()->json([
                 'success'=> true,
                 'data' => $product,
                 'errors' => null,
                 'message' => null,
                 ], 200
             );
         } else {
             return response()->json([
                 'success'=> false,
                 'data' => null,
                 'errors' => null,
                 'message' =>  "Böyle bir product bulunmamadı !",
                 ], 400
             );
         }        
    }

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);
        if(!$product)
        {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' => "Böyle bir product bulunamadı !",
                ], 400
            );
        }
        Gate::authorize("delete", $product);

        $product = $this->productRepository->delete($id);
        if ($product) {
           return response()->json([
                'success'=> true,
                'data' => null,
                'errors' => null,
                'message' => "Product silindi !",
                ], 200
            );
        } else {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' =>  "Böyle bir product bulunmamadı !",
                ], 400
            );
        }
    }
}
