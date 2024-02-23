<?php 

namespace App\Domain\UseCases;
use App\Domain\Entities\ProductEntity;
use App\Domain\UseCases\ImageStorageUseCase;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\UseCases\Interfaces\CreateProductUseCaseInterface;
use Illuminate\Support\Facades\Auth;

class CreateProductUseCase implements CreateProductUseCaseInterface
{
    private $productRepository;
    private $categoryRepository;
    private $imageStorageUseCase;
    private $stockRepositoryInterface;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ImageStorageUseCase $imageStorageUseCase,
        StockRepositoryInterface $stockRepositoryInterface
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageStorageUseCase = $imageStorageUseCase;
        $this->stockRepositoryInterface = $stockRepositoryInterface;
    }

    public function execute(array $data, int $userId): array
    {
        try{
            $product = new ProductEntity();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setExpirationDt($data['expiration_dt']);
            $product->setImage($this->imageStorageUseCase->execute($data['image']));
            $product->setCategory(
                $this->categoryRepository->findById($data['categoryId'])
            );
            $productSaved = $this->productRepository->create($product);            
            $this->stockRepositoryInterface->save($userId, $productSaved->getId());
            return ['isSuccess' => true, 'message' => "Object created successfully." ];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }
    
}
