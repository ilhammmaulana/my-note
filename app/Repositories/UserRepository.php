<?php

namespace App\Repositories;

use App\Models\User;
use Error;
use Spatie\Permission\Models\Role;

interface UserRepositoryInterface
{
    public function getUser($role_id);
    public function countUserByRole($role_id);
    public function register($data);
    public function getOne($id);
}


class UserRepository
{
    public function getUser($roleName, $excludeUser)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return null;
        }

        $data = $role->users()
            ->where('id', '!=', $excludeUser)
            ->latest()
            ->paginate(10);

        return $data;
    }
    public function countUserByRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return null;
        }
        $count = $role->users()->count();
        return $count;
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
    public function getOne($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw new \Exception('User not found');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
