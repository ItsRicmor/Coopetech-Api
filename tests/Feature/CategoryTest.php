<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Category;


class CategoryTest extends TestCase
{
    use RefreshDatabase;

    function testGetAllCategoriesCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $this->get('/api/categories')
            ->assertOk()
            ->assertJson([
                "message" => "Todas las categorías",
                "error" => false,
                "results" => [$category->toArray()],
            ]);
    }

    public function testGetCategoryByIdShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = 1;
        $this->get("/api/categories/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una categotía con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testGetCategoryByIdShouldReturnTheExpectedCategoryCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $id = $category->id;

        $this->get("/api/categories/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Detalles de la categoría",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $category->name,
                ],
            ]);
    }

    public function testCreateCategoryShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->postJson('api/categories', [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "results" => [
                    "name" => [
                        "El nombre es obligatorio"
                    ]
                ]
            ]);
    }

    public function testCreateCategoryShouldSaveACategoryCorrectly()
    {
        $name = "Test name";
        $this->postJson('/api/categories/', ["name" => $name])
            ->assertCreated()
            ->assertJson([
                "message" => "Categoría creada",
                "error" => false,
                "results" => [
                    "name" => $name,
                ],
            ]);
    }

    public function testUpdateCategoryShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $this->putJson('/api/categories/1', ["name" => "test name"])
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una categoría con ID 1",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testUpdateCategoryShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->putJson('/api/categories/1', [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "results" => [
                    "name" => [
                        "El nombre es obligatorio"
                    ]
                ]
            ]);
    }

    public function testUpdateCategoryShouldUpdateACategoryCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $id = $category->id;

        $name = "new test name";
        $this->putJson("/api/categories/$id", ["name" => $name])
            ->assertOk()
            ->assertJson([
                "message" => "Categoría actualizada",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $name,
                ],
            ]);
    }

    public function testDeleteCategoryShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
       $this->deleteJson('/api/categories/1')
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una categoría con ID 1",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testDeleteCategoryShouldRemoveACategoryCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $id = $category->id;

        $this->deleteJson("/api/categories/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Categoría eliminada",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $category->name,
                ],
            ]);
    }
}
