<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\User;

interface CategoryRepositoryInterface
{
    public function getAll($userId);
}

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll($userId)
    {
        $categories = Category::withCount('notes')->where('created_by', $userId)->get();
        return $categories;
    }
    public function createCategory($userId, $data)
    {
        return Category::create([
            "category_name" => $data['category_name'],
            "created_by" => $userId
        ]);
    }

    public function deleteCategory($userId, $categoryId)
    {
        try {
            return Category::where('created_by', $userId)->where('id', $categoryId)->firstOrFail()->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateCategory($userId, $categoryId, $data)
    {
        try {
            return Category::where('created_by', $userId)->where('id', $categoryId)->firstOrFail()->update($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
