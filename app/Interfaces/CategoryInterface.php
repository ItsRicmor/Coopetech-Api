<?php

namespace App\Interfaces;

use App\Http\Requests\CategoryRequest;

interface CategoryInterface
{
    /**
     * Get all categories
     *
     * @method  GET api/categories
     * @access  public
     */
    public function getAllCategories();

    /**
     * Get Category By ID
     *
     * @param   integer     $id
     *
     * @method  GET api/categories/{id}
     * @access  public
     */
    public function getCategoryById($id);

    /**
     * Create | Update category
     *
     * @param   \App\Http\Requests\CategoryRequest   $request
     * @param   integer                              $id
     *
     * @method  POST    api/categories       For Create
     * @method  PUT     api/categories/{id}  For Update
     * @access  public
     */
    public function requestCategory(CategoryRequest $request, $id = null);

    /**
     * Delete category
     *
     * @param   integer     $id
     *
     * @method  DELETE  api/categories/{id}
     * @access  public
     */
    public function deleteCategory($id);
}
