<?php

namespace App\Http\Controllers;

use App\Domain\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
}