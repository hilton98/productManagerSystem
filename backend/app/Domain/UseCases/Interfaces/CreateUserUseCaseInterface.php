<?php

namespace App\Domain\UseCases\Interfaces;
use App\Domain\Entities\CategoryEntity;

interface CreateUserUseCaseInterface
{
    public function execute(array $data): array;
}