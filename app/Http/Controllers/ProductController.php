<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $products = $this->productRepository->all();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        // Kullanıcının ID'sini ekle
        $validatedData['user_id'] = $request->user()->id; // veya auth()->user()->id

        $product = $this->productRepository->create($validatedData);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|integer',
        ]);

        // Kullanıcı ID'si güncelleme sırasında genellikle değiştirilmez
        // Ancak, siz gerekli görürseniz burada da ekleyebilirsiniz
        $product = $this->productRepository->update($id, $validatedData);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);
        return response()->json(null, 204);
    }
}
