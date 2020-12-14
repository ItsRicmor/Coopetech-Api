<?php


namespace App\Interfaces;


use App\Http\Requests\BrandRequest;

interface BrandRepository
{
    /**
     * Get all brands
     *
     * @method  GET api/brands For Get
     * @access  public
     */
    public function getAllBrands();

    /**
     * Get Brand By ID
     *
     * @param   integer     $id
     *
     * @method  GET api/brands/{id} For Get By Id
     * @access  public
     */
    public function getBrandById(int $id);

    /**
     * Create brand
     *
     * @param BrandRequest $request
     *
     * @method  POST    api/brands       For Create
     * @access  public
     */
    public function createBrand(BrandRequest $request);

    /**
     * Update brand
     *
     * @param BrandRequest $request
     * @param Integer $id
     *
     * @method  PUT     api/brands/{id}  For Update
     * @access  public
     */
    public function updateBrand(BrandRequest $request, int $id);

    /**
     * Delete brand
     *
     * @param   integer     $id
     *
     * @method  DELETE  api/brands/{id} For Delete
     * @access  public
     */
    public function deleteBrand(int $id);
}
