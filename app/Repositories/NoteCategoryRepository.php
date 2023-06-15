<?php

namespace App\Repositories;

use App\Models\NoteCategory;

interface NoteCategoryRepositoryInterface
{
    public function attachCategoryToNote($noteId, $categoryId);
}

class NoteCategoryRepository implements NoteCategoryRepositoryInterface
{
    public function attachCategoryToNote($noteId, $categoryId)
    {
        try {
            NoteCategory::create([
                "note_id" => $noteId,
                "category_id" => $categoryId
            ]);
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
