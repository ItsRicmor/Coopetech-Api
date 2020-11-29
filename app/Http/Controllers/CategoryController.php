<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    protected $categoryInterface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(CategoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->categoryInterface->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        return $this->categoryInterface->createCategory($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->categoryInterface->getCategoryById($id);
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
        return $this->categoryInterface->updateCategory($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->categoryInterface->deleteCategory($id);
    }
}
