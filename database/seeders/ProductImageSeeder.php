<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Product::all()->each(function ($product) {
            ProductImage::factory()->count(3)->create([
                'product_id' => $product->id,  // Assign product to the images
            ]);

            // Make the first image the cover
            $firstImage = $product->images()->first();
            $firstImage->update(['is_cover' => true]);
        });
    }
}
