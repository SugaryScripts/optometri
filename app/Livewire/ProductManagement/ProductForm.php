<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Helper\UploadHelper;
use App\Models\ProductImage;
use App\Models\ProductType;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Vinkla\Hashids\Facades\Hashids;

class ProductForm extends Form {
    use HandlesSafeDbOperations;

    public ?\App\Models\Product $product;
    #[Validate]
    public string $name = '';
    #[Validate(onUpdate: false)]
    public ?string $description = '';
    #[Validate]
    public ?string $sku = null;
    #[Validate]
    public ?float $price = null;
    #[Validate]
    public ?string $brand_id = null;
    #[Validate]
    public ?string $product_type_id = null;
    #[Validate]
    public array $selectedVariantAttributes = [];
    #[Validate]
    public array $attributeValues = [];
    #[Validate]
    public $image_file = [];

    public $uploaded_image_id = [];
    public $uploaded_image = [];
    public $uploaded_image_name = [];

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sku' => 'required|string|unique:products,sku' .
                (isset($this->product) ? ',' . $this->product->id : ''),
            'price' => 'required|numeric|min:0',
            'brand_id' => ['required', function ($attribute, $value, $fail) {
                if (!\App\Models\Brand::findByHashed($value)->exists()) {
                    $fail('The selected brand is invalid.');
                }
            }],
            'product_type_id' => ['required', function ($attribute, $value, $fail) {
                if (!ProductType::findByHashed($value)->exists()) {
                    $fail('The selected product type is invalid.');
                }
            }],
            'image_file.*' => 'nullable|image|max:5120',
        ];

        // Add dynamic validation rules for attributes
        if ($this->product_type_id) {
            $productType = ProductType::findByHashed($this->product_type_id);
            if ($productType) {
                foreach ($productType->attributes as $attribute) {
                    $attributeRule = $attribute->required ? 'required' : 'nullable';

                    // Add data type validation
                    switch ($attribute->data_type) {
                        case 'number':
                            $attributeRule .= '|numeric';
                            break;
                        case 'date':
                            $attributeRule .= '|date';
                            break;
                        case 'boolean':
                            $attributeRule .= '|boolean';
                            break;
                        default:
                            $attributeRule .= '|string';
                    }

                    $rules["attributeValues.{$attribute->id}"] = $attributeRule;
                }
            }
        }

        return $rules;
    }
    public function resetAttributes() {
        $this->selectedVariantAttributes = [];
        $this->attributeValues = [];
    }

    public function setData(\App\Models\Product $product): void {
        $this->product = $product;

        $this->name = $product->name;
        $this->description = $product->description;
        $this->sku = $product->sku;
        $this->price = $product->price;
        $this->brand_id = Hashids::encode($product->brand_id);
        $this->product_type_id = Hashids::encode($product->product_type_id);

        foreach ($product->images as $item) {
            $this->uploaded_image_id[] = $item->hashed;
            $this->uploaded_image[] = UploadHelper::getUploadedFile(config('file_path.product'), $product->hashed, $item->file_name);
            $this->uploaded_image_name[] = $item->original_name;
        }

        // Load attribute values
        $this->attributeValues = $product->attributeValues
            ->pluck('value', 'product_attribute_id')
            ->toArray();

        // Load selected variant attributes
        $this->selectedVariantAttributes = $product->variantAttributes()
            ->pluck('product_attributes.id')
            ->toArray();

        // Load non-variant attribute values
        $nonVariantAttributeValues = $product->attributeValues()
            ->whereNotIn('product_attribute_id', $this->selectedVariantAttributes)
            ->get();

        foreach ($nonVariantAttributeValues as $value) {
            $this->attributeValues[$value->product_attribute_id] = $value->value;
        }
    }

    public function store(): bool {
        $this->validate();

        /* Check image if exists  */
        if (!$this->uploaded_image && !$this->image_file) {
            $this->addError('image_file', 'Gambar tidak boleh kosong');
            return false;
        }

        return $this->safeDbOperation(function () {

            $brandId = \App\Models\Brand::decodeHashid($this->brand_id);
            $productTypeId = ProductType::decodeHashid($this->product_type_id);

            $data = \App\Models\Product::create([
                'name' => $this->name,
                'sku' => $this->sku,
                'price' => $this->price,
                'description' => $this->description,
                'product_type_id' => $productTypeId,
                'brand_id' => $brandId
            ]);
            $this->product = $data;
            Debugbar::info('Created new product');


            $IMAGE_PATH = config('file_path.product');
            foreach ($this->image_file as $item) {
                $relativePath = UploadHelper::ensureFileDirectory($IMAGE_PATH, $data->hashed);
                $filename = UploadHelper::store($item, $relativePath);
                $original_name = UploadHelper::getOriginalName($item);

                $file = ProductImage::create([
                    'file_name' => $filename,
                    'original_name' => $original_name,
                    'product_id' => $data->id,
                    'is_cover' => $this->image_file[0] == $item
                ]);

                $this->uploaded_image_id[] = $file->hashed;
                $this->uploaded_image[] = $filename;
                $this->uploaded_image_name[] = $original_name;
            }

        }, 'Failed to create new product');
    }

    public function update(): bool {
        $this->validate();

        /* Check image if exists  */
        if (!$this->uploaded_image && !$this->image_file) {
            $this->addError('image_file', 'Gambar tidak boleh kosong');
            return false;
        }

        return $this->safeDbOperation(function () {

            $brandId = \App\Models\Brand::decodeHashid($this->brand_id);
            $productTypeId = ProductType::decodeHashid($this->product_type_id);

            $this->product->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'price' => $this->price,
                'description' => $this->description,
                'product_type_id' => $productTypeId,
                'brand_id' => $brandId
            ]);

            Debugbar::info('Updated product');


            $IMAGE_PATH = config('file_path.product');
            foreach ($this->image_file as $item) {
                $relativePath = UploadHelper::ensureFileDirectory($IMAGE_PATH, $this->product->hashed);
                $filename = UploadHelper::store($item, $relativePath);
                $original_name = UploadHelper::getOriginalName($item);

                $file = ProductImage::create([
                    'file_name' => $filename,
                    'original_name' => $original_name,
                    'product_id' => $this->product->id,
                    'is_cover' => $this->image_file[0] == $item
                ]);

                $this->uploaded_image_id[] = $file->hashed;
                $this->uploaded_image[] = $filename;
                $this->uploaded_image_name[] = $original_name;
            }

            // Update product type variant attributes
            $productType = $this->product->productType;
            $productType->variantAttributes()->sync($this->selectedVariantAttributes);

            // Update product attributes (non-variant)
            $this->product->attributeValues()
                ->whereNotIn('product_attribute_id', $this->selectedVariantAttributes)
                ->delete();

            foreach ($this->attributeValues as $attributeId => $value) {
                if (!empty($value)) {
                    $this->product->attributeValues()->create([
                        'product_attribute_id' => $attributeId,
                        'value' => $value
                    ]);
                }
            }

        }, 'Failed to create new product');
    }

}
