<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;
use App\Models\Category;
use App\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;


class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMustEnterName()
    {
        $this->json('POST', 'api/categories')
            ->assertStatus(422)
            ->assertJson([
                "message" => "Error de validación",
                "error" => true,
                "code" => 422,
                "results" => [
                    "name" => [
                        "El nombre es obligatorio"
                    ]
                ]
            ]);
    }

    public function testCreateSuccessfully()
    {
        $category = Category::factory()->make();
        $repository = Mockery::mock(CategoryRepository::class);

        $repository->shouldReceive('requestCategory')
            ->with(new CategoryRequest($category->toArray()))
            ->once()
            ->andReturn($category);

        $this->app->instance(CategoryInterface::class, $repository);

        $repository->requestCategory(new CategoryRequest($category->toArray()));
    }
}
