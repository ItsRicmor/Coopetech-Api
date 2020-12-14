<?php


namespace App\Repositories;


use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandCollection;
use App\Interfaces\BrandRepository;
use App\Models\Brand;
use App\Traits\ResponseAPI;
use App\Http\Resources\Brand AS BrandResource;
use Illuminate\Support\Facades\DB;

class BrandRepositoryImp implements BrandRepository
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllBrands()
    {
        try {
            $brands = Brand::all();
            return $this->success("Todas las marcas", new BrandCollection($brands));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBrandById(int $id)
    {
        try {
            $vrand = Brand::find($id);

            if(!$vrand) return $this->error("No se encontro una marca con ID $id", 404);

            return $this->success("Detalles de la marca", new BrandResource($vrand));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function createBrand(BrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::create($request->all());
            DB::commit();
            return $this->success("Marca creada", new BrandResource($brand),  201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateBrand(BrandRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::find($id);

            if(!$brand) return $this->error("No se encontro una marca con ID $id", 404);

            $brand->name = $request->name;

            $brand->save();

            DB::commit();
            return $this->success("Marca actualizada", new BrandResource($brand), 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteBrand(int $id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::find($id);

            if(!$brand) return $this->error("No se encontro una marca con ID $id", 404);

            $brand->delete();

            DB::commit();
            return $this->success("Marca eliminada",  new BrandResource($brand));
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
