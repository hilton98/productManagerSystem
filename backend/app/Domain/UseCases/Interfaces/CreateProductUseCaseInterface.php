<?php

namespace App\Domain\UseCases\Interfaces;
use App\Domain\Entities\ProductEntity;

interface CreateProductUseCaseInterface
{
    public function execute(array $data, int $userId): array;
}