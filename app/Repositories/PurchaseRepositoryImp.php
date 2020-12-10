<?php


namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseRequest;
use App\Interfaces\PurchaseRepository;
use App\Http\Resources\PurchaseCollection;
use App\Http\Resources\Purchase AS PurchaseResource;

class PurchaseRepositoryImp implements PurchaseRepository
{
    use ResponseAPI;

    public function getAllPurchases()
    {
        try {
            $purchases = Purchase::all();
            return $this->success("Todas las compras", new PurchaseCollection($purchases));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getPurchaseById(int $id)
    {
        try {
            $purchase = Purchase::find($id);

            if(!$purchase) return $this->error("No se encontro una compra con ID $id", 404);

            return $this->success("Detalles de la compra", new PurchaseResource($purchase));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function createPurchase(PurchaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create($request->all());

            $this->increaseProductStock($purchase);

            DB::commit();
            return $this->success("Compra creada", new PurchaseResource($purchase),  201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updatePurchase(PurchaseRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::find($id);

            if(!$purchase) return $this->error("No se encontro una compra con ID $id", 404);

            $purchase->description = $request->description;
            $purchase->quantity = $request->quantity;
            $purchase->total = $request->total;
            $purchase->product_id = $request->product_id;

            $purchase->save();

            DB::commit();
            return $this->success("Compra actualizada", new PurchaseResource($purchase), 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deletePurchase(int $id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::find($id);

            if(!$purchase) return $this->error("No se encontro una compra con ID $id", 404);

            $purchase->delete();

            DB::commit();
            return $this->success("Compra eliminada",  new PurchaseResource($purchase));
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $purchase
     */
    protected function increaseProductStock($purchase): void
    {
        $product = Product::find($purchase->product_id);
        $product->quantity += $purchase->quantity;
        $product->save();
    }
}
