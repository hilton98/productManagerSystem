<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\ProductEntity;
use App\Domain\Mappers\ProductMapper;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function findAll(): array
    {
        $categoryRepository = new CategoryRepository();
        $productMapper = new ProductMapper();
        $itemsQueried = Product::all();
        if ($itemsQueried){
            $products = array();
            foreach ($itemsQueried as &$item){
                $products[] = $productMapper->modelToEntity($item, $categoryRepository)->toArray();
            }
            return $products;             
        }
        return null;
    }

    public function findById(int $id): ?ProductEntity
    {
        $categoryRepository = new CategoryRepository();
        $productMapper = new ProductMapper();
        $itemQueried = Product::find($id);
        if ($itemQueried)
            return $productMapper->modelToEntity($itemQueried, $categoryRepository);
        return null;
    }

    public function save(ProductEntity $data): void
    {
        try {
            DB::beginTransaction();
            $productModel = $data->getId() ? Product::findOrFail($data->getId()) : new Product;
            $productModel->name = $data->getName();
            $productModel->description = $data->getDescription();
            $productModel->price = $data->getPrice();
            $productModel->expiration_dt = $data->getExpirationDt();
            $productModel->image = $data->getImage();
            $productModel->category_id = $data->getCategory()->getId();
            $productModel->updated_at = $data->getUpdatedAt();
            $productModel->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function delete(int $id): bool
    {
        try{
            DB::beginTransaction();
            $itemQueried = Product::findOrFail($id);
            $itemQueried->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
