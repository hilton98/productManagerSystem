<?php

namespace App\Domain\UseCases\Interfaces;

interface GetAllCategoriesUseCaseInterface
{
    public function execute(): array;
}