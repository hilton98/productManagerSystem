<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\StockEntity;

interface StockRepositoryInterface
{
    /**
     * @return array
    */
    public function findByUserId(int $userId);

}
