<?php 

namespace App\Domain\UseCases;
use Illuminate\Support\Facades\DB;
use App\Domain\Entities\ProductEntity;
use App\Domain\UseCases\ImageStorageUseCase;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\CreateProductUseCaseInterface;

class CreateProductUseCase implements CreateProductUseCaseInterface
{
    private $productRepository;
    private $categoryRepository;
    private $imageStorageUseCase;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ImageStorageUseCase $imageStorageUseCase
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageStorageUseCase = $imageStorageUseCase;
    }

    public function execute(array $data): array
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
            $this->productRepository->save($product);
            return ['isSuccess' => true, 'message' => "Object created successfully." ];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }
    
}
