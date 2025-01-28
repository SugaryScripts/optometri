<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => $this->faker->word,
            'sku' => strtoupper($this->faker->unique()->lexify('PROD-??????')),
            'price' => $this->faker->randomFloat(0, 20000, 10000000),
            'description' => $this->faker->text,
            'product_type_id' => ProductType::factory(),
            'brand_id' => Brand::factory(), // Optional: can be nullable if no brand is assigned
        ];
    }
}
