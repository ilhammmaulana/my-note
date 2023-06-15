<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreNoteCategoryRequest;
use App\Models\Category;
use App\Models\NoteCategory;
use App\Repositories\NoteCategoryRepository;
use Illuminate\Http\Request;

class NoteCategoryController extends ApiController
{
    protected $noteCategoryRepository;

    public function __construct(NoteCategoryRepository $noteCategoryRepository)
    {
        $this->noteCategoryRepository = $noteCategoryRepository;
    }
    public function store(StoreNoteCategoryRequest $storeNoteCategoryRequest, $idNote)
    {
        try {
            $input = $storeNoteCategoryRequest->only(['category_id']);

            $categoryExists = Category::where('id', $input['category_id'])
                ->where('created_by', $this->guard()->id())
                ->exists();
            $relationExists = NoteCategory::where('category_id', $input['category_id'])
                ->where('note_id', $idNote)
                ->exists();
            if (!$categoryExists) {
                return $this->requestNotFound('Category not found!');
            }
            if ($relationExists) {
                return $this->badRequest('allready_exist', 'Failed!, You allready added for this category');
            }

            $this->noteCategoryRepository->attachCategoryToNote($idNote, $input['category_id']);
            return $this->requestSuccess();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
