<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\UseCases\Interfaces\ValidateOperationProductUseCaseInterface;

class ValidateOperationProductUseCase implements ValidateOperationProductUseCaseInterface
{
    private $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function execute(int $productId, int $userId)
    {
      $stock = $this->stockRepository->findByUserId($userId);
      foreach ($stock as &$item){
          if($item->product_id == $productId)
              return true;
      }
      return false;
    }
    
}
