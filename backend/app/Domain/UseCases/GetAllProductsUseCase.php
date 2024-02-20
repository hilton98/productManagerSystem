<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\UseCases\Interfaces\GetAllProductsUseCaseInterface;

class GetAllProductsUseCase implements GetAllProductsUseCaseInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(): array
    {
        $data = $this->productRepository->findAll();
        if (!$data)
            throw new \Exception('No products registered!');
        return $data;
    }   
}
