<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\UseCases\Interfaces\GetStockUseCaseInterface;

class GetStockUseCase implements GetStockUseCaseInterface
{
    private $stockRepository;
    private $productRepository;

    public function __construct(
      StockRepositoryInterface $stockRepository,
      ProductRepositoryInterface $productRepository
    ){
        $this->stockRepository = $stockRepository;
        $this->productRepository = $productRepository;
    }

    public function execute(int $userId): array
    {
        $stock = $this->stockRepository->findByUserId($userId);
        if (!$stock)
            throw new \Exception('Stock is empty!');
        $products = array();
        foreach ($stock as &$item){
          $products[] = $this->productRepository->findById($item->product_id)->toArray();
        }
        return $products;
    }   
}
