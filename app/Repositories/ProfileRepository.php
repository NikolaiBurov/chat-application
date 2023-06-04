<?php

namespace App\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function getUser(int $id): ?User
    {
        return User::find($id);
    }

    public function saveUser(User $user): void
    {
        $user->save();
    }
}
