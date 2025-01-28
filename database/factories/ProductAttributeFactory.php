<?php

namespace Database\Factories;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => $this->faker->word,
            'data_type' => $this->faker->randomElement(['string', 'number', 'boolean']),
            'required' => $this->faker->boolean,
            'product_type_id' => ProductType::factory(),
        ];
    }
}
