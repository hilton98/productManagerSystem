<?php

namespace App\Domain\UseCases\Interfaces;

interface UpdateCategoryUseCaseInterface
{
    public function execute(int $categoryId, array $data): array;
}