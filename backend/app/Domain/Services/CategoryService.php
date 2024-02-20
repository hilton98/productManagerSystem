<?php

namespace App\Domain\Services;

use App\Domain\Entities\CategoryEntity;
use App\Domain\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        $data = $this->categoryRepository->findAll();
        if (!$data)
            throw new \Exception('No categories registered!');
        return $data;
    }

    public function getCategory(int $id): CategoryEntity
    {
        $data = $this->categoryRepository->findById($id);
        if (!$data)
            throw new \Exception('Category not found!');
        return $data;
    }

    public function create(array $data): CategoryEntity
    {    
        $category = new CategoryEntity();
        $category->setName($data['name']);
        $this->categoryRepository->save($category);
        return $category;
    }

    public function removeCategory(int $id): void
    {    
        $isSuccess = $this->categoryRepository->delete($id);
        if (!$isSuccess)
            throw new \Exception('Non-existent or previously deleted category!');
    }
    
}
