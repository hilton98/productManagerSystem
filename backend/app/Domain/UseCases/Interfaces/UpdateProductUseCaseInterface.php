<?php

namespace App\Domain\UseCases\Interfaces;

interface UpdateProductUseCaseInterface
{
    public function execute(int $productId, array $data): array;
}