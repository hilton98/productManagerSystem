<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\ProductEntity;
use App\Domain\Mappers\ProductMapper;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

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

    public function create(ProductEntity $data): ProductEntity 
    {
        try {
            $model = Product::create([
                'id' => $data->getId(),
                'name' => $data->getName(),
                'description' => $data->getDescription(),
                'price' => $data->getPrice(),
                'expiration_dt' => $data->getExpirationDt(),
                'image' => $data->getImage(),
                'category_id' => $data->getCategory()->getId(),
                'updated_at' => $data->getUpdatedAt(),
                'created_at' => $data->getcreatedAt(),
            ]);
            $product = $this->findById($model->id); 
            return $product;
        } catch (\Exception $e) {
            \Log::error('Error registering product: ' . $e->getMessage());
            throw new \Exception('Error registering product: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function save(ProductEntity $data): void
    {
        try {
            $productModel = Product::findOrFail($data->getId());
            $productModel->name = $data->getName();
            $productModel->description = $data->getDescription();
            $productModel->price = $data->getPrice();
            $productModel->expiration_dt = $data->getExpirationDt();
            $productModel->image = $data->getImage();
            $productModel->category_id = $data->getCategory()->getId();
            $productModel->updated_at = $data->getUpdatedAt();
            $productModel->save();
        } catch (\Exception $e) {
            \Log::error('Error registering product: ' . $e->getMessage());
            throw new \Exception('Error registering product: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function delete(int $id): bool
    {
        try{
            $itemQueried = Product::findOrFail($id);
            $itemQueried->delete();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
