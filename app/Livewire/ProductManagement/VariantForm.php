<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VariantForm extends Form {
    use HandlesSafeDbOperations;

    public ?ProductVariant $productVariant;

    #[Validate]
    public ?string $name = null;
    #[Validate]
    public ?string $sku = null;
    #[Validate]
    public ?float $price = null;

    #[Validate]
    public ?int $product_id = null;

    #[Validate]
    public array $attributeValues = [];

    public $variantAttributes = [];

    public function rules() {
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:product_variants,sku' .
                (isset($this->productVariant) ? ',' . $this->productVariant->id : ''),
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
        ];

        // Dynamically add rules for attribute values based on the variant attributes
        foreach ($this->getVariantAttributes() as $attribute) {
            $attributeRule = $attribute->required ? 'required' : 'nullable';

            // Add additional validation based on data_type
            switch ($attribute->data_type) {
                case 'number':
                    $attributeRule .= '|numeric';
                    break;
                case 'boolean':
                    $attributeRule .= '|boolean';
                    break;
                default: // string
                    $attributeRule .= '|string|max:255';
            }

            $rules["attributeValues.{$attribute->id}"] = $attributeRule;
        }

        return $rules;
    }

    public function validationAttributes() {
        $attributes = [
            'name' => 'Name',
            'sku' => 'SKU',
            'price' => 'Price',
        ];

        // Add custom attribute names for variant attributes
        foreach ($this->getVariantAttributes() as $attribute) {
            $attributes["attributeValues.{$attribute->id}"] = $attribute->name;
        }

        return $attributes;
    }

    public function setProduct(\App\Models\Product $product): void {
        $this->product_id = $product->id;
        $this->variantAttributes = $product->variantAttributes;

        // Initialize empty attribute values
        $this->attributeValues = array_fill_keys(
            $product->variantAttributes->pluck('id')->toArray(),
            ''
        );
    }

    public function setProductVariant(ProductVariant $productVariant): void {
        $this->productVariant = $productVariant;
        $this->name = $productVariant->name;
        $this->sku = $productVariant->sku;
        $this->price = $productVariant->price;
        $this->product_id = $productVariant->product_id;

        // Load attribute values
        $this->attributeValues = $productVariant->attributeValues
            ->pluck('value', 'product_attribute_id')
            ->toArray();
    }

    public function getVariantAttributes() {
        if (empty($this->variantAttributes) && $this->product_id) {
            $this->variantAttributes = Product::find($this->product_id)
                ->variantAttributes()
                ->get();
        }
        return $this->variantAttributes;
    }

    public function store(): bool {
        $this->validate();

        return $this->safeDbOperation(function () {
            // Create variant
            $variant = ProductVariant::create([
                'name' => $this->name,
                'sku' => $this->sku,
                'price' => $this->price,
                'product_id' => $this->product_id,
            ]);

            // Save attribute values
            foreach ($this->attributeValues as $attributeId => $value) {
                if ($value !== '') {
                    $variant->attributeValues()->create([
                        'product_attribute_id' => $attributeId,
                        'value' => $value
                    ]);
                }
            }

            $this->reset();
            return true;
        }, 'Failed to create variant!');
    }

    public function update(): bool {
        $this->validate();

        return $this->safeDbOperation(function () {
            // Update variant
            $this->productVariant->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'price' => $this->price,
            ]);

            // Update attribute values
            foreach ($this->attributeValues as $attributeId => $value) {
                $this->productVariant->attributeValues()->updateOrCreate(
                    ['product_attribute_id' => $attributeId],
                    ['value' => $value]
                );
            }

            return true;
        }, 'Failed to update variant!');
    }
}
