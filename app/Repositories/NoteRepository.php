<?php

namespace App\Repositories;

use App\Models\Note;

interface NoteRepositoryInterface
{
    public function getNotes($idUser);
    public function createNote($idUser, $data);
}


class NoteRepository  implements NoteRepositoryInterface
{
    public function getNotes($idUser)
    {
        $notes = Note::where('created_by', $idUser)->latest()->get();
        return $notes;
    }
    public function createNote($idUser, $data)
    {
        return Note::create([
            "title" => $data["title"],
            "body" => $data["body"],
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
            $find = Note::where('id', $idNote)->where('created_by', $idUser)->firstOrFail()->update($data);
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
}
