<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\CreateNoteRequest;
use App\Http\Requests\API\PinNoteRequest;
use App\Http\Requests\API\UpdateNoteRequest;
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
        $collection = $data->sortByDesc(function ($item) {
            return $item->favorite ? 1 : 0;
        })->values();
        return $this->requestSuccessData($collection);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNoteRequest $createNoteRequest)
    {
        $input = $createNoteRequest->only('title', 'body', 'category_id');
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
            $note = new NoteResource($this->noteRepository->getNote($id, $this->guard()->id()));
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
    public function update(UpdateNoteRequest $updateNoteRequest,  $id)
    {
        try {
            $input = $updateNoteRequest->only('title', 'body', 'category_id');
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
    public function favoriteNote(PinNoteRequest $pinNoteRequest, $id)
    {
        try {
            $input = $pinNoteRequest->only('favorite');
            $input['favorite'] = $input['favorite'];
            $this->noteRepository->favoriteNote($id, $this->guard()->id(), $input['favorite']);
            return $this->requestSuccess();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Note not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getFavoriteNote()
    {
        $notes = NoteResource::collection($this->noteRepository->getFavoriteNote($this->guard()->id()));
        return $this->requestSuccessData($notes);
    }
}
