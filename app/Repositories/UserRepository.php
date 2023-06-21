<?php

namespace App\Repositories;

use App\Models\User;
use Error;

interface UserRepositoryInterface
{
    public function getUser($role_id);
    public function countUserByRole($role_id);
    public function register($data);
}


class UserRepository
{
    public function getUser($role_id, $excludeUser)
    {
        $data = User::where('role_id', $role_id)->where('id', '!=', $excludeUser)->latest()->paginate(10);
        return $data;
    }
    public function countUserByRole($role_id)
    {
        $data = User::where('role_id', $role_id)->count();
        return $data;
    }
    public function register($data)
    {
        try {
            return User::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw new Error('User not found', 404);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
