<?php


namespace App\Repositories;

use App\Models\Product;
use App\Traits\ResponseAPI;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\ProductRepository;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product AS ProductResource;
use Illuminate\Support\Facades\DB;



class ProductRepositoryImp implements ProductRepository
{
    use ResponseAPI;

    public function getAllProducts()
    {
        try {
            $products = Product::with('category')->get();
            return $this->success("Todos los productos", new ProductCollection($products));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductById(string $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if(!$product) return $this->error("No se encontro un producto con ID $id", 404);

            return $this->success("Detalles del producto", new ProductResource($product));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function createProduct(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create($request->all());
            $product->load('category');
            DB::commit();
            return $this->success("Producto creado", new ProductResource($product),  201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateProduct(ProductUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            if(!$product) return $this->error("No se encontro un producto con ID $id", 404);

            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->brand = $request->brand;
            $product->category_id = $request->category_id;

            $product->save();

            $product->load('category');

            DB::commit();
            return $this->success("Producto actualizado", new ProductResource($product), 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteProduct(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            if(!$product) return $this->error("No se encontro un producto con ID $id", 404);

            $product->delete();

            DB::commit();
            return $this->success("Producto eliminada",  new ProductResource($product));
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
