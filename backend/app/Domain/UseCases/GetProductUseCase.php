<?php 

namespace App\Domain\UseCases;
use App\Domain\Entities\ProductEntity;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\UseCases\Interfaces\GetProductUseCaseInterface;

class GetProductUseCase implements GetProductUseCaseInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id): ProductEntity
    {
        $data = $this->productRepository->findById($id);
        if (!$data)
            throw new \Exception('Product not found!');
        return $data;
    }   
}
