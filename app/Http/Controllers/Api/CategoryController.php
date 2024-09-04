<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
         // Request'ten page ve perPage parametrelerini alıyoruz. 
         $page = $request->input('page', 1); 
         $perPage = $request->input('per_page', 10); 
 
        $categorys = $this->categoryRepository->all($page,$perPage);
        return response()->json([
            'success' => true,
            'data' => $categorys,
            'errors' => null,
            'message' => null,
        ], 200);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category) {
            return response()->json([
                'success' => true,
                'data' => $category,
                'errors' => null,
                'message' => null,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => 'Brand not found.',
                'message' => 'The requested category does not exist.',
            ], 400);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $category = $this->categoryRepository->create($validatedData);
            return response()->json([
                'success' => true,
                'data' => $category,
                'errors' => null,
                'message' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Failed to create the category.',
            ], 400);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $category = $this->categoryRepository->update($id, $validatedData);
        if ($category) 
        {
            return response()->json([
                'success' => true,
                'data' => $category,
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
        $brand = $this->categoryRepository->delete($id);
        if ($brand) {
           return response()->json([
                'success'=> true,
                'data' => null,
                'errors' => null,
                'message' => "category silindi !",
                ], 200
            );
        } else {
            return response()->json([
                'success'=> false,
                'data' => null,
                'errors' => null,
                'message' =>  "Böyle bir category bulunmamadı !",
                ], 400
            );
        }
    }
}
