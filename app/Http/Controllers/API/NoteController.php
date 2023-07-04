<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\CreateNoteRequest;
use App\Http\Requests\API\PinNoteRequest;
use App\Http\Requests\API\StoreNoteImageRequest;
use App\Http\Requests\API\UpdateNoteRequest;
use App\Http\Resources\API\NoteResource;
use App\Http\Resources\ImageNoteResource;
use App\Models\Category;
use App\Models\ImageNote;
use App\Models\Note;
use Illuminate\Support\Str;
use App\Repositories\NoteRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $rawData = $this->noteRepository->getNotes($this->guard()->id());
        $data = NoteResource::collection($rawData);
        // $collection = $data->sortByDesc(function ($item) {
        //     return $item->favorite ? 1 : 0;
        // })->values();
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
        try {
            $input = $createNoteRequest->only('title', 'body', 'category_id');
            if (isset($input['category_id'])) {
                $category = Category::where('created_by', $this->guard()->id())
                    ->findOrFail($input['category_id']);
                $categoryIdExist = true;
            }
            $createdNote = $this->noteRepository->createNote($this->guard()->id(), $input);
            if (isset($categoryIdExist)) {
                $this->noteRepository->attachCategoryToNote($createdNote->id, $input['category_id']);
            }
            return $this->requestSuccess('Success!', 201);
        } catch (ModelNotFoundException $e) {
            return $this->requestNotFound('Category not found');
        } catch (\Throwable $th) {
            throw $th;
        }
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
            $this->noteRepository->deleteNoteWithImages($id, $this->guard()->id());
            return $this->requestSuccess();
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
    public function storeImageNote(StoreNoteImageRequest $storeNoteImageRequest, $id)
    {

        try {
            $note = Note::findOrFail($id);
            $image = $storeNoteImageRequest->file('image');
            $userId = $this->guard()->id();

            $userFolderPath = 'public/images/note-images/' . $userId;
            if (!Storage::exists($userFolderPath)) {
                Storage::makeDirectory($userFolderPath);
            }

            $noteFolderPath = $userFolderPath . '/' . $note->id;
            if (!Storage::exists($noteFolderPath)) {
                Storage::makeDirectory($noteFolderPath);
            }

            $fileName = "NOT3APP" . Str::random(20) . Carbon::now()->format('YmdHms') . '.' . $image->getClientOriginalExtension();
            $image->storeAs($noteFolderPath, $fileName);

            DB::beginTransaction();

            try {
                $data = new ImageNoteResource(ImageNote::create([
                    "note_id" => $id,
                    "image" => $noteFolderPath . '/' . $fileName
                ]));
                DB::commit();

                return $this->requestSuccessData($data, 201);
            } catch (\Exception $e) {
                DB::rollBack();
                Storage::delete($noteFolderPath . $fileName);
                throw $e;
            }
        } catch (ModelNotFoundException $exception) {
            return $this->requestNotFound('Note not found!');
        }
    }
    public function deleteImageNote($imageNoteId)
    {
        try {
            $imageNote = ImageNote::findOrFail($imageNoteId);
            $noteId = $imageNote->note_id;
            $note = Note::where('id', $noteId)
                ->where('created_by', $this->guard()->id())
                ->first();

            if ($note) {
                $imagePath = $imageNote->image;
                $imageNote->delete();
                Storage::delete($imagePath);
                $folderPath = dirname($imagePath);
                $files = Storage::files($folderPath);
                if (empty($files)) {
                    Storage::deleteDirectory($folderPath);
                    $userFolderPath = dirname($folderPath);
                    $userFiles = Storage::allFiles($userFolderPath);
                    if (empty($userFiles)) {
                        Storage::deleteDirectory($userFolderPath);
                    }
                }

                return $this->requestSuccess('Success!');
            } else {
                return $this->requestNotFound('Image note not found!');
            }
        } catch (ModelNotFoundException $exception) {
            return $this->requestNotFound('Image note not found!');
        }
    }
}
