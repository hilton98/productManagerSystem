<?php 

namespace App\Domain\UseCases;
use App\Domain\UseCases\ImageStorageUseCase;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\UseCases\Interfaces\UpdateProductUseCaseInterface;
use Illuminate\Support\Facades\DB;

class UpdateProductUseCase implements UpdateProductUseCaseInterface
{
    private $productRepository;
    private $categoryRepository;
    private $imageStorageUseCase;
    private $stockRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ImageStorageUseCase $imageStorageUseCase,
        StockRepositoryInterface $stockRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageStorageUseCase = $imageStorageUseCase;
        $this->stockRepository = $stockRepository;
    }
    
    public function execute(int $productId, int $userId, array $data): array
    {
        try {
            $product = $this->productRepository->findById($productId);    
            if (!$product)
                return ['isSuccess' => false, 'message' => 'Product not found.'];

            if (!$this->validUser($productId, $userId))
                return ['isSuccess' => false, 'message' => 'No product in personal stock!'];
            
            $product->setName($this->assignValue($data, 'name', $product->getName()));
            $product->setDescription($this->assignValue($data, 'description', $product->getDescription()));
            $product->setPrice($this->assignValue($data, 'price', $product->getPrice()));
            $product->setExpirationDt($this->assignValue($data, 'expiration_dt', $product->getExpirationDt()));
            $product->setImage(
                $this->imageStorageUseCase->execute(
                    $this->assignValue($data, 'image', $product->getImage())
                )
            );
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

    private function validUser($product_id, $userId)
    {
        $stock = $this->stockRepository->findByUserId($userId);
        foreach ($stock as &$item){
            if($item->product_id == $product_id)
                return true;
        }
        return false;
    }
}
