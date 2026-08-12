<?php

namespace App\Services\User;

use App\Models\User;

class StoreUserService
{
    public function run(array $data): ?User
    {
        return User::create($data)->load('role');
    }
}
