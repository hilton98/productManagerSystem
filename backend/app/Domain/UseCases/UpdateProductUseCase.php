<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\UpdateProductUseCaseInterface;
use Illuminate\Support\Facades\DB;

class UpdateProductUseCase implements UpdateProductUseCaseInterface
{
    private $productRepository;
    private $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(int $productId, array $data): array
    {
        try {
            $product = $this->productRepository->findById($productId);    
            if (!$product)
                return ['isSuccess' => false, 'message' => 'Product not found.'];
            
            $product->setName($this->assignValue($data, 'name', $product->getName()));
            $product->setDescription($this->assignValue($data, 'description', $product->getDescription()));
            $product->setPrice($this->assignValue($data, 'price', $product->getPrice()));
            $product->setExpirationDt($this->assignValue($data, 'expiration_dt', $product->getExpirationDt()));
            $product->setImage($this->assignValue($data, 'image', $product->getImage()));
            $product->setCategory($this->assignCategory($data, 'categoryId', $product->getCategory()));
            $product->setUpdatedAt(now());
            $this->productRepository->save($product);    
            return ['isSuccess' => true, 'message' => 'Product updated successfully.'];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }

    private function assignValue($columns, $index, $data)
    {
        if(isset($columns[$index])){
            return $columns[$index];
        }
        return $data;
    }
    
    private function assignCategory($columns, $index, $data){
        if (isset($columns[$index])){
            $category = $this->categoryRepository->findById($columns[$index]);
            if ($category)
                return $category;
        }
        return $data;
    }
}
