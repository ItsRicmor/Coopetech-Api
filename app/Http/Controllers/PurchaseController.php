<?php

namespace App\Http\Controllers;

use App\Interfaces\PurchaseRepository;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Response;

class PurchaseController extends Controller
{
    protected $repository;

    /**
     * Create a new constructor for this controller
     * @param PurchaseRepository $purchaseRepository
     */
    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->repository = $purchaseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->getAllPurchases();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  PurchaseRequest  $request
     * @return Response
     */
    public function store(PurchaseRequest $request)
    {
        return $this->repository->createPurchase($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->repository->getPurchaseById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PurchaseRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PurchaseRequest $request, int $id)
    {
        return $this->repository->updatePurchase($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->repository->deletePurchase($id);
    }
}
