<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Entities\CategoryEntity;
use App\Domain\UseCases\Interfaces\CreateCategoryUseCaseInterface;
use Illuminate\Support\Facades\DB;

class CreateCategoryUseCase implements CreateCategoryUseCaseInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(array $data): CategoryEntity
    {
        $category = new CategoryEntity();
        $category->setName($data['name']);
        $this->categoryRepository->save($category);
        return $category;
    }
    
}
