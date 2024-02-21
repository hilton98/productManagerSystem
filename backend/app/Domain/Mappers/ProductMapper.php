<?php 

namespace App\Domain\Mappers;

use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Entities\ProductEntity;
use App\Models\Product;

class ProductMapper
{

    public static function modelToEntity(Product $model, CategoryRepositoryInterface $categoryRepository): ProductEntity
    {
        $product = new ProductEntity();
        $product->setId($model->id);
        $product->setName($model->name);
        $product->setDescription($model->description);
        $product->setPrice($model->price);
        $product->setExpirationDt($model->expiration_dt);
        $product->setImage(env('APP_URL')."/images/".$model->image);
        $product->setCategory($categoryRepository->findById($model->category_id));
        $product->setCreatedAt($model->created_at);
        $product->setUpdatedAt($model->updated_at);
        return $product;
    }
}

