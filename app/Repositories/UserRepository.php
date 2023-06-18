<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUser($role_id);
}


class UserRepository
{
    public function getUser($role_id)
    {
        $data = User::where('role_id', $role_id)->paginate(10);
        return $data;
    }
}
