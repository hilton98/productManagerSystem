<?php

namespace App\Domain\UseCases\Interfaces;
use App\Domain\Entities\ProductEntity;

interface GetProductUseCaseInterface
{
    public function execute(int $id): ProductEntity;
}