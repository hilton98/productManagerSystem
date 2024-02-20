<?php 

namespace App\Domain\UseCases;
use App\Domain\Entities\CategoryEntity;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\GetCategoryUseCaseInterface;

class GetCategoryUseCase implements GetCategoryUseCaseInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(int $id): CategoryEntity
    {
        $data = $this->categoryRepository->findById($id);
        if (!$data)
            throw new \Exception('Category not found!');
        return $data;
    }   
}
