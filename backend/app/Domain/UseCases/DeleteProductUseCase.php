<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\UseCases\Interfaces\DeleteProductUseCaseInterface;

class DeleteProductUseCase implements DeleteProductUseCaseInterface
{
    private $stockRepository;
    private $validateOperation;

    public function __construct(
        StockRepositoryInterface $stockRepository,
        ValidateOperationProductUseCase $validateOperationProductUseCase
    )
    {
        $this->stockRepository = $stockRepository;
        $this->validateOperation = $validateOperationProductUseCase;
    }

    public function execute(int $id, int $userId): array
    {
        if (!$this->validateOperation->execute($id, $userId))
            return ['isSuccess' => false, 'message' => 'No product in personal stock!'];

        $isSuccess = $this->stockRepository->delete($id);
        if (!$isSuccess)
            throw new \Exception('Non-existent or previously deleted product!');
        
        return ['isSuccess' => true, 'message' => 'Product removed!'];
    }
    
}
