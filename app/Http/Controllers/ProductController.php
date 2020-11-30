<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\ProductRepository;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    protected $repository;

    /**
     * Create a new constructor for this controller
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->getAllProducts();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
            return $this->repository->createProduct($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return Response
     */
    public function show(string $id)
    {
        return $this->repository->getProductById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest  $request
     * @param  string  $id
     * @return Response
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        return $this->repository->updateProduct($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    public function destroy(string $id)
    {
        return $this->repository->deleteProduct($id);
    }
}
