<?php

namespace App\Domain\UseCases\Interfaces;

interface GetAllProductsUseCaseInterface
{
    public function execute(): array;
}