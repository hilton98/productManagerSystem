<?php

namespace App\Http\Controllers;
use App\Domain\UseCases\UpdateCategoryUseCase;
use App\Domain\UseCases\CreateCategoryUseCase;
use App\Domain\UseCases\DeleteCategoryUseCase;
use App\Domain\UseCases\GetCategoryUseCase;
use App\Domain\UseCases\GetAllCategoriesUseCase;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $updateCategoryUseCase;
    private $createCategoryUseCase;
    private $deleteCategoryUseCase;
    private $getCategoryUseCase;
    private $getAllCategoriesUseCase;

    public function __construct(
        UpdateCategoryUseCase $updateCategoryUseCase,
        CreateCategoryUseCase $createCategoryUseCase,
        DeleteCategoryUseCase $deleteCategoryUseCase,
        GetCategoryUseCase $getCategoryUseCase,
        GetAllCategoriesUseCase $getAllCategoriesUseCase
    )
    {
        $this->updateCategoryUseCase = $updateCategoryUseCase;
        $this->createCategoryUseCase = $createCategoryUseCase;
        $this->deleteCategoryUseCase = $deleteCategoryUseCase;
        $this->getCategoryUseCase = $getCategoryUseCase;
        $this->getAllCategoriesUseCase = $getAllCategoriesUseCase;
    }

    public function getAllItems()
    {
        try {
            $categories = json_encode($this->getAllCategoriesUseCase->execute());
            return response($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getItemById(int $id)
    {
        try {
            $category = $this->getCategoryUseCase->execute($id);
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
        $category = $this->createCategoryUseCase->execute($formData);
        return response()->json('Created', 201);
    }

    public function delete(int $id)
    {
        try {
            $category = $this->deleteCategoryUseCase->execute($id);
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