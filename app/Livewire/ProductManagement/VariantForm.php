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


    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'data_type' => 'required|in:string,number,boolean',
            'required' => 'boolean',
            'product_type_id' => 'required|exists:product_types,id',
            'attributeValues.*' => 'nullable',
        ];
    }

    public function setProductVariant(ProductVariant $productVariant): void {
        $this->productVariant = $productVariant;
        $this->name = $productVariant->name;
        $this->sku = $productVariant->data_type;
        $this->price = $productVariant->required;
        $this->product_id = $productVariant->product_id;
    }

    public function store() {
        $this->validate();

        return $this->safeDbOperation(function () {
            ProductAttribute::create($this->pull());
            $this->reset();
        }, 'Failed to create attribute!');
    }

    public function update() {
        $this->validate();

        return $this->safeDbOperation(function () {
            $this->productVariant->update($this->pull());
        }, 'Failed to update attribute!');
    }
}
