<?php

namespace App\Domain\Repositories;
use App\Models\User;
use App\Domain\Entities\UserEntity;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function save(UserEntity $data): void
    {
        try {
            DB::beginTransaction();
            User::create([
                'name' => $data->getName('name'),
                'email' => $data->getEmail('email'),
                'password' => $data->getPassword('password'),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}