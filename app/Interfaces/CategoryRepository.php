<?php

namespace App\Interfaces;

use App\Http\Requests\CategoryRequest;

interface CategoryRepository
{
    /**
     * Get all categories
     *
     * @method  GET api/categories For Get
     * @access  public
     */
    public function getAllCategories();

    /**
     * Get Category By ID
     *
     * @param   integer     $id
     *
     * @method  GET api/categories/{id} For Get By Id
     * @access  public
     */
    public function getCategoryById(int $id);

    /**
     * Create category
     *
     * @param CategoryRequest $request
     *
     * @method  POST    api/categories       For Create
     * @access  public
     */
    public function createCategory(CategoryRequest $request);

    /**
     * Update category
     *
     * @param CategoryRequest $request
     * @param Integer $id
     *
     * @method  PUT     api/categories/{id}  For Update
     * @access  public
     */
    public function updateCategory(CategoryRequest $request, int $id);

    /**
     * Delete category
     *
     * @param   integer     $id
     *
     * @method  DELETE  api/categories/{id} For Delete
     * @access  public
     */
    public function deleteCategory(int $id);
}
