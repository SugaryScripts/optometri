<?php

namespace Database\Factories;

use App\Helper\FileDirHandler;
use App\Helper\SlugHelper;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory {
    use FileDirHandler;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $name = fake()->unique()->company();
        $slug = SlugHelper::generateUniqueSlug($name, Brand::class);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(),
            'image_filename' => null,
            'image_original_name' => $this->faker->word . '.jpg',
        ];
    }

    public function configure() {
        return $this->afterMaking(function (Brand $brand) {
            // No action needed here
        })->afterCreating(function (Brand $brand) {
            $brandId = $brand->hashed;
            // Ensure brand directory exists
            $this->ensureFileDirectory(config('file_path.brand'), $brandId);

            // Generate an image in the correct folder
            $image = $this->faker->image(
                $this->getProjectFilePath(config('file_path.brand'), $brandId),
                640,
                640,
                false
            );

            // Update the file_name field with the generated image name
            $brand->update([
                'image_filename' => basename($image),
            ]);
        });
    }

}
