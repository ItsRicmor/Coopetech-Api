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

    public function getCategoryById($id)
    {
        try {
            $category = Category::find($id);

            // Check the category
            if(!$category) return $this->error("No se encontro una categotía con ID $id", 404);

            return $this->success("Detalles de la categoría", new CategoryResource($category));
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestCategory(CategoryRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If category exists when we find it
            // Then update the category
            // Else create the new one.
            $category = $id ? Category::find($id) : new Category;

            // Check the category
            if($id && !$category) return $this->error("No se encontro una categoría con ID $id", 404);

            $category->name = $request->name;

            // Save the user
            $category->save();

            DB::commit();
            return $this->success(
                $id ? "Categoría actualizada"
                    : "Categoría creada",
                $category, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteCategory($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);

            // Check the category
            if(!$category) return $this->error("No se encontro una categoría con ID $id", 404);

            // Delete the category
            $category->delete();

            DB::commit();
            return $this->success("Categoría eliminada",  new CategoryResource($category));
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
