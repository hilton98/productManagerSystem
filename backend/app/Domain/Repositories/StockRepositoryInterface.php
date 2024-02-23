<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\StockEntity;

interface StockRepositoryInterface
{
    /**
     * @return array
    */
    public function findByUserId(int $userId);

    /**
     * @return void
    */
    public function save(int $userId, int $productId);

    /**
     * @return bool
    */
    public function delete(int $id);

}
