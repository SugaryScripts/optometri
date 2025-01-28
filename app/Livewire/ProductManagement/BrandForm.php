<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Helper\SlugHelper;
use App\Helper\UploadHelper;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class BrandForm extends Form {
    use HandlesSafeDbOperations;

    public ?\App\Models\Brand $brand;
    #[Validate]
    public string $name = '';
    #[Validate]
    public ?string $description = '';
    #[Validate]
    public $image_file;

    public $uploaded_image;
    public $uploaded_image_name;

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|max:5120',
        ];
    }

    public function update() {
        $this->validate();
        $brand = $this->brand;

        /* Check image if exists  */
        if (!$this->uploaded_image && !$this->image_file){
            $this->addError('image_file', 'Gambar tidak boleh kosong');
            return false;
        }

        return $this->safeDbOperation(function() use ($brand) {
            $IMAGE_PATH = config('file_path.brand');

            if (isset($this->image_file)) {
                $relativePath = UploadHelper::ensureFileDirectory($IMAGE_PATH, $brand->hashed);
                $filename = UploadHelper::store($this->image_file, $relativePath);
                UploadHelper::deleteFile($relativePath, $brand->image_filename);

                Debugbar::info($relativePath);
                Debugbar::info("Deleted " . $brand->image_filename);

                $image_filename = $filename;
                $image_original_name = UploadHelper::getOriginalName($this->image_file);

                $brand->image_filename = $image_filename;
                $brand->image_original_name = $image_original_name;

                Debugbar::info($image_filename);
            }

            $brand->name = $this->name;
            $brand->slug = SlugHelper::generateUniqueSlug($this->name, \App\Models\Brand::class);
            $brand->description = $this->description;
            $brand->save();

            Debugbar::info('Updated brand');

            return $brand;
        }, 'Failed to update brand');
    }

    public function store(): bool {
        $this->validate();

        /* Check image if exists  */
        if (!$this->uploaded_image && !$this->image_file){
            $this->addError('image_file', 'Gambar tidak boleh kosong');
            return false;
        }

        return $this->safeDbOperation(function() {
            $IMAGE_PATH = config('file_path.brand');
            $image_filename = '';
            $image_original_name = '';

            $data = \App\Models\Brand::create([
                'name' => $this->name,
                'slug' => SlugHelper::generateUniqueSlug($this->name, \App\Models\Brand::class),
                'description' => $this->description,
            ]);
            Debugbar::info('Created brand');

            if (isset($this->image_file)) {
                $relativePath = UploadHelper::ensureFileDirectory($IMAGE_PATH, $data->hashed);
                Debugbar::info($this->image_file);
                $filename = UploadHelper::store($this->image_file, $relativePath);
                Debugbar::info($relativePath);
                Debugbar::info($filename);

                $image_filename = $filename;
                $image_original_name = UploadHelper::getOriginalName($this->image_file);
            }
            Debugbar::info('Uploaded image');

            $data->update([
                'image_filename' => $image_filename,
                'image_original_name' => $image_original_name
            ]);
            Debugbar::info('Updated brand with new uploaded filename');

            //return true;

        }, 'Failed to create brand');
    }

    public function setData(\App\Models\Brand $brand) {
        $this->brand = $brand;
        $this->name = $this->brand->name;
        $this->description = $this->brand->description;
        $this->uploaded_image = UploadHelper::getUploadedFile(config('file_path.brand'), $this->brand->hashed,  $this->brand->image_filename);
        $this->uploaded_image_name = $this->brand->image_original_name;
    }

    public function deleteImage(): bool {
        return $this->safeDbOperation(function() {
            $IMAGE_PATH = config('file_path.brand');

            $filepath = $IMAGE_PATH . $this->brand->hashed;
            Storage::disk('public')->deleteDirectory($filepath);

            Debugbar::info("Directory deleted ".$filepath);

            $this->brand->image_filename = null;
            $this->brand->image_original_name = null;
            $this->brand->save();

            $this->uploaded_image = null;
            $this->uploaded_image_name = null;

            Debugbar::info('Updated brand');

        }, 'Failed to delete image');
    }
}
