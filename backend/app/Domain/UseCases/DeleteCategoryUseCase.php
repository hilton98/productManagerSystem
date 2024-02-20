<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\DeleteCategoryUseCaseInterface;

class DeleteCategoryUseCase implements DeleteCategoryUseCaseInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(int $id): void
    {
        $isSuccess = $this->categoryRepository->delete($id);
        if (!$isSuccess)
            throw new \Exception('Non-existent or previously deleted category!');
    }
    
}
