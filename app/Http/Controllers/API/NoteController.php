<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\CreateNoteRequest;
use App\Http\Requests\API\PinNoteRequest;
use App\Http\Resources\API\NoteResource;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class NoteController extends ApiController
{
    private $noteRepository;
    /**
     * Class constructor.
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NoteResource::collection($this->noteRepository->getNotes($this->guard()->id()));
        return $this->requestSuccessData($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNoteRequest $createNoteRequest)
    {
        $input = $createNoteRequest->only('title', 'body');
        $this->noteRepository->createNote($this->guard()->id(), $input);
        return $this->requestSuccess('Success!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $note = $this->noteRepository->getNote($id, $this->guard()->id());
            return $this->requestSuccessData($note);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Note not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateNoteRequest $createNoteRequest,  $id)
    {
        try {
            $input = $createNoteRequest->only('title', 'body');
            $this->noteRepository->updateNote($id, $this->guard()->id(), $input);
            return $this->requestSuccess('Success!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Note not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->noteRepository->deleteNote($id, $this->guard()->id());
            return $this->requestSuccess('Success!', 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Note not found!');
        } catch (\Throwable $th) {
            return $this->badRequest($th->getMessage());
        }
    }
    public function pinNote(PinNoteRequest $pinNoteRequest, $id)
    {
        try {
            $input = $pinNoteRequest->only('pinned');
            $input['pinned'] = (bool)$input['pinned'];
            $this->noteRepository->pinNote($id, $this->guard()->id(), $input['pinned']);
            return $this->requestSuccess();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getNotesPin()
    {
        $notes = $this->noteRepository->getPinNote($this->guard()->id());
        return $this->requestSuccessData($notes);
    }
}
