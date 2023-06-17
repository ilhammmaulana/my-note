<?php

use App\Repositories\NoteRepository;

interface NoteServiceInterface
{
    public function deleteNote($idNote, $idUser);
}

class NoteService
{
    private $noteRepository;
    /**
     * Class constructor.
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function deleteNote($idNote, $idUser)
    {
    }
}
