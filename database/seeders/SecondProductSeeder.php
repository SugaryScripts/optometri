<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductType;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Create product types with their attributes
        ProductType::factory(5)->create()->each(function ($productType) {
            // Create 4-6 attributes for each product type
            ProductAttribute::factory()
                ->count(random_int(4, 6))
                ->create([
                    'product_type_id' => $productType->id,
                ]);

            // Create products for each product type
            Product::factory(3)->create([
                'product_type_id' => $productType->id,
                'brand_id' => rand(0, 1) ? Brand::inRandomOrder()->value('id') : null,
            ])->each(function ($product) use ($productType) {
                // Get all available attributes for this product type
                $allAttributes = $productType->attributes;

                // Randomly select 1-2 attributes as variant attributes for this product
                $variantAttributeCount = random_int(1, 2);
                $variantAttributes = $allAttributes->random($variantAttributeCount);

                // Attach selected attributes as variant attributes
                $product->variantAttributes()->attach($variantAttributes->pluck('id'));

                // Add values for non-variant attributes
                $nonVariantAttributes = $allAttributes->diff($variantAttributes);
                foreach ($nonVariantAttributes as $attribute) {
                    ProductAttributeValue::factory()->create([
                        'product_attribute_id' => $attribute->id,
                        'attributable_type' => Product::class,
                        'attributable_id' => $product->id,
                    ]);
                }

                // Create variants with their attribute values
                $variantCount = random_int(2, 4);
                ProductVariant::factory($variantCount)
                    ->create([
                        'product_id' => $product->id,
                        'price' => abs($product->price + rand(-50000, 50000)),
                    ])
                    ->each(function ($variant) use ($variantAttributes) {
                        // Add values for variant attributes
                        foreach ($variantAttributes as $attribute) {
                            ProductAttributeValue::factory()->create([
                                'product_attribute_id' => $attribute->id,
                                'attributable_type' => ProductVariant::class,
                                'attributable_id' => $variant->id,
                            ]);
                        }
                    });
            });
        });
    }
}
