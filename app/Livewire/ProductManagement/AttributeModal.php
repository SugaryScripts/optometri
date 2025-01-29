<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use App\Models\ProductAttribute;
use Livewire\Attributes\On;
use Vinkla\Hashids\Facades\Hashids;

class AttributeModal extends BaseComponent {
    public AttributeForm $form;

    public function mount($hashed = '') {
        if (isset($hashed)){
            $this->form->product_type_id = Hashids::decode($hashed)[0];
        }
    }

    public function render() {
        return view('product-management.attribute-modal');
    }

    #[On('getData')]
    public function getData($attributeId) {
        $attribute = ProductAttribute::findByHashedOrFail($attributeId);
        $this->form->setAttribute($attribute);
        $this->dispatch('showModal');
    }

    #[On('clearVars')]
    public function clearVars(){
        $this->form->reset();
    }

    public function save() {
        if (isset($this->form->attribute)){
            if ($this->form->update()){
                $message = 'Data updated successfully';
                $this->dispatch('sessionFlash', $message);
            }
        }else {
            if ($this->form->store()){
                $message = 'Data created successfully';
                $this->dispatch('sessionFlash', $message);
            }
        }

        $this->dispatch('closeModal');
    }

}
