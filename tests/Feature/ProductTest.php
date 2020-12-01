<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetAllProductsCorrectly()
    {
        $product = Product::factory()->create();
        $product->save();
        $this->get('/api/products')
            ->assertOk()
            ->assertJson([
                "message" => "Todos los productos",
                "error" => false,
                "results" => [$product->toArray()],
            ]);
    }

    public function testGetProductByIdShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = 1;
        $this->get("/api/products/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro un producto con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testGetCategoryByIdShouldReturnTheExpectedCategoryCorrectly()
    {
        $product = Product::factory()->create();
        $product->save();
        $id = $product->id;
        $this->get("/api/products/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Detalles del producto",
                "error" => false,
                "results" => $product->toArray(),
            ]);
    }

    public function testCreateProductShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->postJson('api/products', [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "code" => 422,
                "results" => [
                    "id" => [
                        "El codigo del producto es obligatorio"
                    ],
                    "description" => [
                        "La descripción es obligatoria"
                    ],
                    "quantity" => [
                        "La cantidad es requerida"
                    ],
                    "price" => [
                        "El precio es obligatorio"
                    ],
                    "brand" => [
                        "La marca es obligatoria"
                    ],
                    "category_id" => [
                        "El id de la categoría es obligatorio"
                    ]
                ]
            ]);
    }

    public function testCreateProductShouldSaveAProductCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $product = [
            "id" => "f7edb97e-ff65-3945-899d-29e41a52f3f5",
            "description" => "Prof. Ottilie Schaefer I",
            "quantity" => 5,
            "price" => 1000.0,
            "brand" => "Stehr, Reichert and Weber",
            "category_id" => $category->id
        ];
        $this->postJson('/api/products', $product)
            ->assertCreated()
            ->assertJson([
                "message" => "Producto creado",
                "error" => false,
                "results" => $product,
            ]);
    }

    public function testUpdateProductShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $category = Category::factory()->create();
        $category->save();
        $product = [
            "id" => "f7edb97e-ff65-3945-899d-29e41a52f3f5",
            "description" => "Prof. Ottilie Schaefer I",
            "quantity" => 5,
            "price" => 1000.0,
            "brand" => "Stehr, Reichert and Weber",
            "category_id" => $category->id
        ];
        $this->putJson('/api/products/123AD', $product)
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro un producto con ID 123AD",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testUpdateProductShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->putJson('/api/products/1', [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "results" => [
                    "description" => [
                        "La descripción es obligatoria"
                    ],
                    "quantity" => [
                        "La cantidad es requerida"
                    ],
                    "price" => [
                        "El precio es obligatorio"
                    ],
                    "brand" => [
                        "La marca es obligatoria"
                    ],
                    "category_id" => [
                        "El id de la categoría es obligatorio"
                    ]
                ]
            ]);
    }

    public function testUpdateProductShouldUpdateAPurchaseCorrectly()
    {
        $category = Category::factory()->create();
        $category->save();
        $id = "f7edb97e-ff65-3945-899d-29e41a52f3f5";
        $product = new Product([
            "id" => $id,
            "description" => "Prof. Ottilie Schaefer I",
            "quantity" => 5,
            "price" => 1000.0,
            "brand" => "Stehr, Reichert and Weber",
            "category_id" => $category->id
        ]);

        $product->save();

        $product->description = "New description asfasdf";
        $product->quantity = 10;
        $product->price = 2000.0;
        $product->brand = "New Brandasdfasdf asd";

        $this->putJson("/api/products/$id", $product->toArray())
            ->assertOk()
            ->assertJson([
                "message" => "Producto actualizado",
                "error" => false,
                "results" => $product->toArray(),
            ]);
    }

    public function testDeleteProductShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = "f7edb97e-ff65-3945-899d-29e41a52f3f5";
        $this->deleteJson("/api/products/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro un producto con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testDeleteProductShouldRemoveAProductCorrectly()
    {
        $product = Product::factory()->create();
        $product->save();
        $id = $product->id;

        $this->deleteJson("/api/products/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Producto eliminada",
                "error" => false,
                "results" => $product->toArray(),
            ]);
    }

}
