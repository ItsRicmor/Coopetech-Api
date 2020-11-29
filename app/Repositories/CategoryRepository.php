<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\CategoryInterface;
use App\Traits\ResponseAPI;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category AS CategoryResource;

class CategoryRepository implements CategoryInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllCategories()
    {
        try {
            $categories = Category::all();
            return $this->success("Todas las categorías", new CategoryCollection($categories));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getCategoryById(int $id)
    {
        try {
            $category = Category::find($id);

            if(!$category) return $this->error("No se encontro una categotía con ID $id", 404);

            return $this->success("Detalles de la categoría", new CategoryResource($category));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function createCategory(CategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::create($request->all());
            DB::commit();
            return $this->success("Categoría creada", $category,  201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateCategory(CategoryRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);

            if($id && !$category) return $this->error("No se encontro una categoría con ID $id", 404);

            $category->name = $request->name;

            $category->save();

            DB::commit();
            return $this->success("Categoría actualizada", $category, 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteCategory(int $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);

            if(!$category) return $this->error("No se encontro una categoría con ID $id", 404);

            $category->delete();

            DB::commit();
            return $this->success("Categoría eliminada",  new CategoryResource($category));
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
