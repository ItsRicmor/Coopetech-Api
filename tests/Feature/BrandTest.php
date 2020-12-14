<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    function testGetAllBrandsCorrectly()
    {
        $brand = Brand::factory()->create();
        $brand->save();
        $this->get('/api/brands')
            ->assertOk()
            ->assertJson([
                "message" => "Todas las marcas",
                "error" => false,
                "results" => [$brand->toArray()],
            ]);
    }

    public function testGetBrandByIdShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = 1;
        $this->get("/api/brands/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una marca con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testGetBrandByIdShouldReturnTheExpectedBrandCorrectly()
    {
        $brand = Brand::factory()->create();
        $brand->save();
        $id = $brand->id;

        $this->get("/api/brands/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Detalles de la marca",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $brand->name,
                ],
            ]);
    }

    public function testCreateBrandShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->postJson('api/brands', [])
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

    public function testCreateBrandShouldSaveABrandCorrectly()
    {
        $name = "Test name";
        $this->postJson('/api/brands/', ["name" => $name])
            ->assertCreated()
            ->assertJson([
                "message" => "Marca creada",
                "error" => false,
                "results" => [
                    "name" => $name,
                ],
            ]);
    }

    public function testUpdateBrandShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $this->putJson('/api/brands/1', ["name" => "test name"])
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una marca con ID 1",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testUpdateBrandShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->putJson('/api/brands/1', [])
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

    public function testUpdateBrandsShouldUpdateABrandsCorrectly()
    {
        $brand = Brand::factory()->create();
        $brand->save();
        $id = $brand->id;

        $name = "new test name";
        $this->putJson("/api/brands/$id", ["name" => $name])
            ->assertOk()
            ->assertJson([
                "message" => "Marca actualizada",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $name,
                ],
            ]);
    }

    public function testDeleteBrandShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $this->deleteJson('/api/brands/1')
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una marca con ID 1",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testDeleteBrandShouldRemoveABrandCorrectly()
    {
        $brand = Brand::factory()->create();
        $brand->save();
        $id = $brand->id;

        $this->deleteJson("/api/brands/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Marca eliminada",
                "error" => false,
                "results" => [
                    "id" => $id,
                    "name" => $brand->name,
                ],
            ]);
    }
}
