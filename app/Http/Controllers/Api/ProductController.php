<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
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

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
                
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

        // Kullanıcı ID'si güncelleme sırasında genellikle değiştirilmez
        // Ancak, siz gerekli görürseniz burada da ekleyebilirsiniz
        
    }

    public function destroy($id)
    {
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
