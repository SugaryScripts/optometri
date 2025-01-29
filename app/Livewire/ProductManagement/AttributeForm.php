<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Models\ProductAttribute;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttributeForm extends Form {
    use HandlesSafeDbOperations;

    public ?ProductAttribute $attribute;

    #[Validate]
    public ?string $name = '';
    #[Validate]
    public ?string $data_type = 'text';
    #[Validate]
    public bool $required = false;
    #[Validate]
    public ?int $product_type_id = null;

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'data_type' => 'required|in:string,number,boolean',
            'required' => 'boolean',
            'product_type_id' => 'required|exists:product_types,id'
        ];
    }

    public function setAttribute(ProductAttribute $attribute): void {
        $this->attribute = $attribute;
        $this->name = $attribute->name;
        $this->data_type = $attribute->data_type;
        $this->required = $attribute->required;
        $this->product_type_id = $attribute->product_type_id;
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
            $this->attribute->update($this->pull());
        }, 'Failed to update attribute!');
    }
}
