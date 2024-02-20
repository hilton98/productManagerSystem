<?php

namespace App\Domain\UseCases\Interfaces;

interface DeleteCategoryUseCaseInterface
{
    public function execute(int $id): void;
}