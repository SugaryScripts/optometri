<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductType;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Create some product types
        ProductType::factory(5)->create();

        // Create products for each product type and brand
        $productTypes = ProductType::all();

        $productTypes->each(function ($productType) {
            Product::factory(3)->create([
                'product_type_id' => $productType->id,
                'brand_id' => rand(0, 1) ? Brand::inRandomOrder()->value('id') : null, // 50% chance to assign a brand
            ])->each(function ($product) {
                // Attach random attributes to the product
                $attributes = ProductAttribute::factory(2)->create([
                    'product_type_id' => $product->product_type_id,
                ]);

                $attributes->each(function ($attribute) use ($product) {
                    ProductAttributeValue::factory()->create([
                        'product_attribute_id' => $attribute->id,
                        'attributable_type' => Product::class,
                        'attributable_id' => $product->id,
                    ]);
                });

                // Create variants for products
                ProductVariant::factory()->count(rand(0, 3))->create([
                    'product_id' => $product->id,
                    'price' => abs($product->price + rand(-50000, 50000)), // Variant price around product price
                ]);

                // Optionally, you can add attributes to variants as well
                ProductVariant::all()->each(function ($variant) {
                    ProductAttributeValue::factory()->create([
                        'product_attribute_id' => ProductAttribute::first()->id, // Assuming attributes are created
                        'attributable_type' => ProductVariant::class,
                        'attributable_id' => $variant->id,
                    ]);
                });
            });
        });
    }
}
