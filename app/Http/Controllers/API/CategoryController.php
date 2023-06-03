<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateCategoryRequest;
use App\Http\Requests\API\UpdateCategory;
use App\Http\Resources\API\CategoryResource;
use App\Http\Resources\API\NoteResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    protected $categoryRepository, $noteRepository;
    /**
     * Class constructor.
     */
    public function __construct(CategoryRepository $categoryRepository, NoteRepository $noteRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->noteRepository = $noteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryResource::collection($this->categoryRepository->getAll($this->guard()->id()));
        return $this->requestSuccessData($categories);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $createCategoryRequest)
    {
        $input = $createCategoryRequest->only('category_name');
        $categoryCreate = $this->categoryRepository->createCategory($this->guard()->id(), $input);
        return $this->requestSuccessData($categoryCreate, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $updateCategory, $id)
    {
        try {
            $input = $updateCategory->only('category_name');
            $this->categoryRepository->updateCategory($this->guard()->id(), $id, $input);
            return $this->requestSuccess();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Category not found!');
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
            $this->categoryRepository->deleteCategory($this->guard()->id(), $id);
            return $this->requestSuccess();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Category not found!');
        } catch (\Throwable $th) {
            throw $th;
            // return $this->badRequest();
        }
    }
    public function getNoteByCategoryId($id)
    {
        $categoryExists = Category::where('id', $id)->exists();

        if (!$categoryExists) {
            return $this->requestNotFound('Category not found!');
        }
        $notes = NoteResource::collection($this->noteRepository->getNoteByCategoryId($id, $this->guard()->id()));

        return $this->requestSuccessData($notes);
    }
}
