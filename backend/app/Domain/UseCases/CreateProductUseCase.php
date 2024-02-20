<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Entities\ProductEntity;
use App\Domain\UseCases\Interfaces\CreateProductUseCaseInterface;
use Illuminate\Support\Facades\DB;

class CreateProductUseCase implements CreateProductUseCaseInterface
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

    public function execute(array $data): ProductEntity
    {
        $product = new ProductEntity();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setExpirationDt($data['expiration_dt']);
        $product->setImage($data['image']);
        $product->setCategory(
            $this->categoryRepository->findById($data['categoryId'])
        );
        $this->productRepository->save($product);
        return $product;
    }
    
}
