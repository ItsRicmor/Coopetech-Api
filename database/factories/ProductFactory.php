<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::factory()->create();
        $category->save();
        return [
            'id' => $this->faker->uuid,
            'description' => $this->faker->name,
            'quantity' => 5,
            'price' => 1000.0,
            'brand' => $this->faker->company,
            'category_id' => $category->id
        ];
    }
}
