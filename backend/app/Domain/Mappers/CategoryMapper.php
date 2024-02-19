<?php 

namespace App\Domain\Mappers;

use App\Domain\Entities\CategoryEntity;
use App\Models\Category;

class CategoryMapper
{
    public static function modelToEntity(Category $categoryModel): CategoryEntity
    {
        $categoryEntity = new CategoryEntity();
        $categoryEntity->setId($categoryModel->id);
        $categoryEntity->setName($categoryModel->name);
        $categoryEntity->setCreatedAt($categoryModel->created_at);
        $categoryEntity->setUpdatedAt($categoryModel->updated_at);

        return $categoryEntity;
    }
}
