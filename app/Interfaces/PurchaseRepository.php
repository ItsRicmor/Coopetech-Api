<?php


namespace App\Interfaces;

use App\Http\Requests\PurchaseRequest;

interface PurchaseRepository
{
    /**
     * Get all purchases
     *
     * @method  GET api/purchases For Get
     * @access  public
     */
    public function getAllPurchases();

    /**
     * Get Purchase By ID
     *
     * @param int $id
     *
     * @method  GET api/purchases/{
    id
    } For Get By Id
     * @access  public
     */
    public function getPurchaseById(int $id);

    /**
     * Create purchase
     *
     * @param PurchaseRequest $request
     *
     * @method  POST    api/purchases       For Create
     * @access  public
     */
    public function createPurchase(PurchaseRequest $request);

    /**
     * Update purchase
     *
     * @param PurchaseRequest $request
     * @param int $id
     *
     * @method  PUT     api/purchases/{id}  For Update
     * @access  public
     */
    public function updatePurchase(PurchaseRequest $request, int $id);

    /**
     * Delete purchase
     *
     * @param   int     $id
     *
     * @method  DELETE  api/products/{id} For Delete
     * @access  public
     */
    public function deletePurchase(int $id);
}
