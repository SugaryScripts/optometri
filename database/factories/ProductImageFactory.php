<?php

namespace Database\Factories;

use App\Helper\FileDirHandler;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory {
    use FileDirHandler;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'original_name' => $this->faker->word . '.jpg',
            'file_name' => null,
            'is_cover' => $this->faker->boolean(20),
            'product_id' => Product::factory(),
        ];
    }

    public function configure() {
        return $this->afterMaking(function (ProductImage $productImage) {
            // No action needed here
        })->afterCreating(function (ProductImage $productImage) {
            $productId = $productImage->product->hashed;

            // Ensure only one cover image exists for the product
            $hasCover = ProductImage::where('product_id', $productId)->where('is_cover', true)->exists();
            if (!$hasCover) {
                $productImage->update(['is_cover' => true]);
            }

            // Ensure brand directory exists
            $this->ensureFileDirectory(config('file_path.product'), $productId);

            // Generate an image in the correct folder
            $image = $this->faker->image(
                $this->getProjectFilePath(config('file_path.product'), $productId),
                640,
                640,
                false
            );

            // Update the file_name field with the generated image name
            $productImage->update([
                'file_name' => basename($image),
            ]);
        });
    }
}
