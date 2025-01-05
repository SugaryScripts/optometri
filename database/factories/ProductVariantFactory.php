<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'sku' => strtoupper($this->faker->unique()->lexify('VAR-??????')),
            'price' => $this->faker->randomFloat(0, 20000, 10000000),
            'product_id' => Product::factory(),
        ];
    }
}
