<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\CategoryEntity;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Mappers\CategoryMapper;
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
        $itemQueried = Category::findOrFail($id);
        if ($itemQueried)
            return $categoryMapper->modelToEntity($itemQueried);
        return null;
    }

    public function save(CategoryEntity $data): void
    {
        try{
            DB::beginTransaction();
            if ($data->getId()) {
                $categoryModel = Category::findOrFail($data->getId());
                $categoryModel->name = $data->getName();
                $categoryModel->updated_at = $data->getUpdatedAt();
            }else{
                $categoryModel = new Category;
                $categoryModel->name = $data->getName();
            }
            $categoryModel->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function delete(int $id): bool
    {
        try{
            DB::beginTransaction();
            $itemQueried = Category::findOrFail($id);
            $itemQueried->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
