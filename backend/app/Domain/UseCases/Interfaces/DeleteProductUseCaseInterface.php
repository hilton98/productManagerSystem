<?php

namespace App\Domain\UseCases\Interfaces;

interface DeleteProductUseCaseInterface
{
    public function execute(int $id, int $userId): array;
}