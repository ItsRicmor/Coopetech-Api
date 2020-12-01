<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    function testGetAllPurchasesCorrectly()
    {
        $purchase = Purchase::factory()->create();
        $purchase->save();
        $this->get('/api/purchases')
            ->assertOk()
            ->assertJson([
                "message" => "Todas las compras",
                "error" => false,
                "results" => [$purchase->toArray()],
            ]);
    }

    public function testGetPurchaseByIdShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = 1;
        $this->get("/api/purchases/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una compra con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testGetPurchaseByIdShouldReturnTheExpectedCategoryCorrectly()
    {
        $purchase = Purchase::factory()->create();
        $purchase->save();
        $id = $purchase->id;
        $this->get("/api/purchases/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Detalles de la compra",
                "error" => false,
                "results" => $purchase->toArray(),
            ]);
    }

    public function testCreatePurchaseShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->postJson('api/purchases', [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "code" => 422,
                "results" => [
                    "description" => [
                        "La descripción es obligatoria"
                    ],
                    "quantity" => [
                        "La cantidad es requerida"
                    ],
                    "total" => [
                        "El precio es obligatorio"
                    ],
                    "product_id" => [
                        "El id del producto es obligatorio"
                    ]
                ]
            ]);
    }

    public function testCreatePurchaseShouldSaveACategoryCorrectly()
    {
        $product = Product::factory()->create();
        $product->save();
        $purchase = [
            "description" => "Prof. Ottilie Schaefer I",
            "quantity" => 5,
            "total" => 1000,
            "product_id" => $product->id,
        ];
        $this->postJson('/api/purchases', $purchase)
            ->assertCreated()
            ->assertJson([
                "message" => "Producto creado",
                "error" => false,
                "results" => $purchase,
            ]);
    }

    public function testUpdatePurchaseShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $product = Product::factory()->create();
        $product->save();
        $purchase = [
            "description" => "Prof. Ottilie Schaefer I",
            "quantity" => 5,
            "total" => 1000,
            "product_id" => $product->id,
        ];
        $this->putJson('/api/purchases/1', $purchase)
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una compra con ID 1",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testUpdatePurchaseShouldReturnValidationErrorsWhenRequestDataIsWrong()
    {
        $this->putJson('/api/purchases/1', [])
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
                    "total" => [
                        "El precio es obligatorio"
                    ],
                    "product_id" => [
                        "El id del producto es obligatorio"
                    ]
                ]
            ]);
    }

    public function testUpdatePurchaseShouldUpdateAPurchaseCorrectly()
    {
        $purchase = Purchase::factory()->create();

        $purchase->save();

        $purchase->description = "New description asfasdf";
        $purchase->quantity = 10;
        $purchase->total = 2000.0;
        $id = $purchase->id;
        $this->putJson("/api/purchases/$id", $purchase->toArray())
            ->assertOk()
            ->assertJson([
                "message" => "Compra actualizada",
                "error" => false,
                "results" => $purchase->toArray(),
            ]);
    }

    public function testDeletePurchaseShouldReturnNotFoundWhenIdDoesNotExistInDatabase()
    {
        $id = 1;
        $this->deleteJson("/api/purchases/$id")
            ->assertNotFound()
            ->assertJson([
                "message" => "No se encontro una compra con ID $id",
                "error" => true,
                "results" => null,
            ]);
    }

    public function testDeleteProductShouldRemoveAProductCorrectly()
    {
        $purchase = Purchase::factory()->create();
        $purchase->save();
        $id = $purchase->id;

        $this->deleteJson("/api/purchases/$id")
            ->assertOk()
            ->assertJson([
                "message" => "Compra eliminada",
                "error" => false,
                "results" => $purchase->toArray(),
            ]);
    }

}
