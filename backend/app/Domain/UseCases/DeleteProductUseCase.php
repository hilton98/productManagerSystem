<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\UseCases\Interfaces\DeleteProductUseCaseInterface;

class DeleteProductUseCase implements DeleteProductUseCaseInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id): void
    {
        $isSuccess = $this->productRepository->delete($id);
        if (!$isSuccess)
            throw new \Exception('Non-existent or previously deleted product!');
    }
    
}
