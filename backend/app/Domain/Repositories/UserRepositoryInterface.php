<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    /**
     * @return UserEntity
    */
    public function save(UserEntity $data);
}
