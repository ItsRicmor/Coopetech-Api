<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\CategoryRepository;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    protected $repository;

    /**
     * Create a new constructor for this controller
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @OA\Get(
     *     path="/projects",
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function index()
    {
        return $this->repository->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        return $this->repository->createCategory($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->repository->getCategoryById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Integer $id
     * @return Response
     */
    public function update(CategoryRequest $request, int $id)
    {
        return $this->repository->updateCategory($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->repository->deleteCategory($id);
    }
}
