<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use App\Models\ProductVariant;
use Livewire\Attributes\On;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class VariantModal extends BaseComponent {
    public VariantForm $form;

    public $variantAttributes = [];

    public function mount($hashed = '') {
        if (isset($hashed)) {
            $this->form->product_id = Hashids::decode($hashed)[0];
            $product = \App\Models\Product::findByHashedOrFail($hashed);
            $this->variantAttributes = $product->variantAttributes;
        }
    }

    public function render() {
        return view('product-management.variant-modal');
    }

    #[On('getData')]
    public function getData($variantId) {
        $variant = ProductVariant::findByHashedOrFail($variantId);
        $this->form->setProductVariant($variant);
        $this->dispatch('showModal');
    }

    #[On('clearVars')]
    public function clearVars() {
        $this->form->reset();
    }

    public function save() {
        if (isset($this->form->productVariant)) {
            if ($this->form->update()) {
                $this->alert('success', 'Berhasil!', [
                    'text' => 'Data updated successfully'
                ]);
            }
        } else {
            if ($this->form->store()) {
                $this->alert('success', 'Berhasil!', [
                    'text' => 'Data created successfully'
                ]);
            }
        }
        $this->dispatch('closeModal');
    }
}
