<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\CategoryEntity;
use App\Domain\Mappers\CategoryMapper;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findAll(): array
    {
        $categoryMapper = new CategoryMapper();
        $itemsQueried = Category::all();
        if ($itemsQueried){
            $categories = array();
            foreach ($itemsQueried as &$item){
                $categories[] = $categoryMapper->modelToEntity($item)->toArray();
            }
            return $categories;             
        }
        return null;
    }

    public function findById(int $id): ?CategoryEntity
    {
        $categoryMapper = new CategoryMapper();
        $itemQueried = Category::find($id);
        if ($itemQueried)
            return $categoryMapper->modelToEntity($itemQueried);
        return null;
    }

    public function save(CategoryEntity $data): void
    {
        try {
            DB::beginTransaction();
            $categoryModel = new Category;
            $categoryModel->name = $data->getName();
            $categoryModel->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
