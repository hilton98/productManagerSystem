<?php

namespace App\Domain\UseCases\Interfaces;

interface UpdateProductUseCaseInterface
{
    public function execute(int $productId, int $userId, array $data): array;
}