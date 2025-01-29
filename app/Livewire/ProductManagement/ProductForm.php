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
    //#[Validate]
    //public array $variants = [];
    #[Validate]
    public $image_file = [];

    public $uploaded_image_id = [];
    public $uploaded_image = [];
    public $uploaded_image_name = [];

    public function rules() {
        return [
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

            'attributeValues.*' => 'nullable',
            /*'variants.*.sku' => 'required|distinct|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.attributeValues.*' => 'nullable',*/

            'image_file.*' => 'nullable|image|max:5120',
        ];
    }

    public function resetAttributes() {
        $this->selectedVariantAttributes = [];
        $this->attributeValues = [];
        $this->variants = [];
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

        // Load variants with their attribute values
        $this->variants = $product->variants->map(function ($variant) {
            $variantData = [
                'id' => $variant->hashed,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'attributeValues' => []
            ];

            foreach ($this->selectedVariantAttributes as $attributeId) {
                $value = $variant->attributeValues()
                    ->where('product_attribute_id', $attributeId)
                    ->first();

                $variantData['attributeValues'][$attributeId] = $value?->value ?? '';
            }

            return $variantData;
        })->toArray();
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

}
