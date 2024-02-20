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

    public function execute(array $data): array
    {
        try{
            $category = new CategoryEntity();
            $category->setName($data['name']);
            $this->categoryRepository->save($category);
            return ['isSuccess' => true, 'message' => "Object created successfully." ];
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'message' => $e->getMessage()];
        }
    }
    
}
