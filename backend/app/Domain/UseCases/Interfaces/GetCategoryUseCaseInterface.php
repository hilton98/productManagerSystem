<?php

namespace App\Domain\UseCases\Interfaces;
use App\Domain\Entities\CategoryEntity;

interface GetCategoryUseCaseInterface
{
    public function execute(int $id): CategoryEntity;
}