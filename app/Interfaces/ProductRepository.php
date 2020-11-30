<?php

namespace App\Interfaces;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;

interface ProductRepository
{
    /**
     * Get all products
     *
     * @method  GET api/products For Get
     * @access  public
     */
    public function getAllProducts();

    /**
     * Get Product By ID
     *
     * @param   string     $id
     *
     * @method  GET api/products/{id} For Get By Id
     * @access  public
     */
    public function getProductById(string $id);

    /**
     * Create product
     *
     * @param ProductRequest $request
     *
     * @method  POST    api/products       For Create
     * @access  public
     */
    public function createProduct(ProductRequest $request);

    /**
     * Update product
     *
     * @param ProductUpdateRequest $request
     * @param string $id
     *
     * @method  PUT     api/products/{id}  For Update
     * @access  public
     */
    public function updateProduct(ProductUpdateRequest $request, string $id);

    /**
     * Delete product
     *
     * @param   string     $id
     *
     * @method  DELETE  api/products/{id} For Delete
     * @access  public
     */
    public function deleteProduct(string $id);
}
