<?php

namespace App\Domain\UseCases\Interfaces;
use App\Domain\Entities\CategoryEntity;

interface CreateCategoryUseCaseInterface
{
    public function execute(array $data): CategoryEntity;
}