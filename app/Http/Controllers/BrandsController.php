<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Interfaces\BrandRepository;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandsController extends Controller
{
    protected $repository;

    /**
     * Create a new constructor for this controller
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->repository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->getAllBrands();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return Response
     */
    public function store(BrandRequest $request)
    {
        return $this->repository->createBrand($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->repository->getBrandById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(BrandRequest $request, int $id)
    {
        return $this->repository->updateBrand($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->repository->deleteBrand($id);
    }
}
