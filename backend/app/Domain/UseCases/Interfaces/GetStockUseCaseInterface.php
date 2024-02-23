<?php

namespace App\Domain\UseCases\Interfaces;
interface GetStockUseCaseInterface
{
    public function execute(int $userId): array;
}