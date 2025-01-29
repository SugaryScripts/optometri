<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use App\Models\ProductVariant;
use Livewire\Attributes\On;
use Vinkla\Hashids\Facades\Hashids;

class VariantModal extends BaseComponent {
    public VariantForm $form;

    public function mount($hashed = '') {
        if ($hashed) {
            $product = \App\Models\Product::findByHashedOrFail($hashed);
            $this->form->setProduct($product);
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
