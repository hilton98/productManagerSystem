<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\ProductEntity;

interface ProductRepositoryInterface
{
    /**
     * @return array
    */
    public function findAll();

    /**
     * @return ProductEntity
    */
    public function findById(int $id);

    /**
     * @return ProductEntity
    */
    public function create(ProductEntity $data);

    /**
     * @return void
    */
    public function save(ProductEntity $data);
    
    /**
     * @return bool
    */
    public function delete(int $id);
}
