<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Models\ProductType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TypeForm extends Form {
    use HandlesSafeDbOperations;

    public ?\App\Models\ProductType $type;
    #[Validate]
    public string $name = '';
    #[Validate]
    public ?string $description = '';

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function setData(\App\Models\ProductType $type) {
        $this->type = $type;
        $this->name = $this->type->name;
        $this->description = $this->type->description;
    }

    public function store(): bool {
        $this->validate();

        return $this->safeDbOperation(function () {

            $type = ProductType::create($this->only([
                'name', 'description'
            ]));
            $this->type = $type;
        }, 'Failed to create product type!');
    }

    public function update(): bool {
        $this->validate();

        return $this->safeDbOperation(function () {
            $this->type->update($this->all());
        }, 'Failed to update product type!');
    }
}
