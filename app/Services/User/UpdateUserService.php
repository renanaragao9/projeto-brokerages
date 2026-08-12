<?php

namespace App\Services\User;

use App\Models\User;

class UpdateUserService
{
    public function run(User $user, array $data): ?User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user->load('role');
    }
}
