<?php

namespace App\Repositories;

use App\Models\Note;
use App\Models\NoteCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

interface NoteRepositoryInterface
{
    public function getNotes($idUser);
    public function createNote($idUser, $data);
    public function getNote($idNote, $idUser);
    public function updateNote($idNote, $idUser, $data);
    public function deleteNote($idNote, $idUser);
    public function favoriteNote($idNote, $idUser, $pinnedCondition);
    public function getFavoriteNote($idUser);
    public function getNoteByCategoryId($idCategory, $createdBy);
}


class NoteRepository  implements NoteRepositoryInterface
{
    public function getNotes($idUser)
    {
        $notes = Note::with('categories', 'imagesNote')->where('created_by', $idUser)->latest('updated_at')->get();
        return $notes;
    }
    public function createNote($idUser, $data)
    {
        return Note::create([
            "title" => isset($data["title"]) ? $data["title"] : null,
            "body" => isset($data["body"]) ? $data["body"] : null,
            "created_by" => $idUser,
        ]);
    }
    public function getNote($idNote, $idUser)
    {
        try {
            return Note::where('id', $idNote)->where('created_by', $idUser)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        }
    }
    public function updateNote($idNote, $idUser, $data)
    {
        try {
            Note::where('id', $idNote)->where('created_by', $idUser)->firstOrFail()->update($data);
            return;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteNote($idNote, $idUser)
    {
        try {
            $find = Note::where('id', $idNote)->where('created_by', $idUser)->firstOrFail()->delete();
            return;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function favoriteNote($idNote, $idUser, $pinnedCondition)
    {
        try {
            $note = Note::where('id', $idNote)->where('created_by', $idUser)->firstOrFail()->update([
                "favorite" => $pinnedCondition
            ]);
            return;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getFavoriteNote($idUser)
    {
        $notes = Note::where('created_by', $idUser)->where('favorite', true)->get();
        return $notes;
    }
    public function getNoteByCategoryId($idCategory, $createdBy)
    {
        try {
            $notes = Note::where('category_id', $idCategory)->where('created_by', $createdBy)->get();
            return $notes;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function attachCategoryToNote($noteId, $categoryId)
    {
        return NoteCategory::create([
            'note_id' => $noteId,
            'category_id' => $categoryId
        ]);
    }
    public function deleteNoteWithImages($noteId, $userId)
    {
        return DB::transaction(function () use ($noteId, $userId) {
            $note = Note::where('id', $noteId)
                ->where('created_by', $userId)
                ->firstOrFail();
            $images = $note->imagesNote()->get();
            foreach ($images as $image) {
                Storage::delete($image->image);
            }

            $note->imagesNote()->delete();

            $note->delete();

            return true;
        });
    }
}
