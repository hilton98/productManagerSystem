<?php

namespace App\Http\Controllers;
use App\Domain\UseCases\UpdateCategoryUseCase;
use App\Domain\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    private $updateCategoryUseCase;

    public function __construct(CategoryService $categoryService, UpdateCategoryUseCase $updateCategoryUseCase)
    {
        $this->categoryService = $categoryService;
        $this->updateCategoryUseCase = $updateCategoryUseCase;
    }

    public function getAllItems()
    {
        try {
            $categories = json_encode($this->categoryService->getAll());
            return response($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getItemById(int $id)
    {
        try {
            $category = $this->categoryService->getCategory($id);
            return response($category->toJson());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request)
    {
        $formData = [
            'name' => $request->input('nome'),
        ];
        $category = $this->categoryService->create($formData);
        return response()->json('Created', 201);
    }

    public function deleteById(int $id)
    {
        try {
            $category = $this->categoryService->removeCategory($id);
            return response()->json(['success' => 'Category removed!'], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $formData = [
            'name' => $request->input('nome'),
        ];
        $result = $this->updateCategoryUseCase->execute($id, $formData);
        return response()->json($result, $result['isSuccess'] ? 200 : 400);
    }

}