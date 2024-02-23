<?php

namespace App\Domain\UseCases\Interfaces;

interface ValidateOperationProductUseCaseInterface
{
    public function execute(int $productId, int $userId);
}