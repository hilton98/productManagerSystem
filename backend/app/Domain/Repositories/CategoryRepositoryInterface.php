<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\CategoryEntity;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return array
    */
    public function findAll();

    /**
     * @return CategoryEntity
    */
    public function findById(int $id);

    /**
     * @return void
    */
    public function save(CategoryEntity $data);
    
    /**
     * @return bool
    */
    public function delete(int $id);
}
