<?php

namespace App\Domain\UseCases\Interfaces;

interface ImageStorageUseCaseInterface
{
    public function execute(string $data): string;
}