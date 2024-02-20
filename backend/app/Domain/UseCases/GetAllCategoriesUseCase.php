<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\GetAllCategoriesUseCaseInterface;

class GetAllCategoriesUseCase implements GetAllCategoriesUseCaseInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(): array
    {
        $data = $this->categoryRepository->findAll();
        if (!$data)
            throw new \Exception('No categories registered!');
        return $data;
    }   
}
