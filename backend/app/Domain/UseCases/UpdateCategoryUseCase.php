<?php 

namespace App\Domain\UseCases;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\UseCases\Interfaces\UpdateCategoryUseCaseInterface;
use Illuminate\Support\Facades\DB;

class UpdateCategoryUseCase implements UpdateCategoryUseCaseInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(int $categoryId, array $data): array
    {
        try {
            $category = $this->categoryRepository->findById($categoryId);    
            if (!$category)
                return ['isSuccess' => false, 'message' => 'Category not found.'];
    
            if (!isset($data['name']))
                return ['isSuccess' => false, 'message' => 'Name is required for category update.'];
            
            $category->setName($data['name']);
            $category->setUpdatedAt(now());
            $this->categoryRepository->save($category);    
            return ['isSuccess' => true, 'message' => 'Category updated successfully.'];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }
    
}
