<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\CategoryEntity;

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
    
    // /**
    //  * @return void
    // */
    // public function delete(CategoryEntity $data);
}
