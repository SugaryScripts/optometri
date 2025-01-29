<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributeValue>
 */
class ProductAttributeValueFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'value' => $this->faker->word,
            'product_attribute_id' => ProductAttribute::factory(),
            'attributable_type' => $this->faker->randomElement([Product::class, ProductVariant::class]),
            'attributable_id' => Product::factory(), // Or Variant::factory() for variants
        ];
    }

    public function configure() {
        return $this->afterMaking(function (ProductAttributeValue $attributeValue) {
            // No action needed here
        })->afterCreating(function (ProductAttributeValue $attributeValue) {
            // Update the file_name field with the generated image name
            $attributeValue->update([
                'value' => match ($attributeValue->productAttribute->data_type) {
                    'string' => $this->faker->word,
                    'number' => (string) $this->faker->numberBetween(1, 100),
                    'boolean' => $this->faker->boolean() ? 'true' : 'false',
                },
            ]);
        });
    }

}
