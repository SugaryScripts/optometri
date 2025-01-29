<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use App\Models\ProductType;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEditor extends BaseComponent {
    use WithFileUploads;

    public ProductForm $form;

    public $brands = [];
    public $productTypes = [];

    public $availableAttributes = [];

    public function mount(string $hashed = '') {
        if ($hashed) {
            $data = \App\Models\Product::findByHashedOrFail($hashed);
            $this->form->setData($data);

            if ($this->form->product_type_id) {
                $this->loadProductTypeAttributes();
            }
        }

        $this->brands = \App\Models\Brand::all();
        $this->productTypes = ProductType::all();

        if (session()->has('status')) {
            $this->alert('success', 'Berhasil!', [
                'text' => session('status')
            ]);
        }
    }

    public function updatedFormProductTypeId() {
        $this->form->resetAttributes();
        $this->loadProductTypeAttributes();
    }

    public function render() {
        return view('product-management.product-editor', [
            'variants' => $this->form->product?->variants ?? collect()
        ]);
    }

    public function save() {
        if (isset($this->form->product)) {
            $result = $this->form->update();
            $message = 'Data updated successfully';
            Debugbar::info($message);
        } else {
            $result = $this->form->store();
            $message = 'Data created successfully';
            Debugbar::info($message);
        }

        //Debugbar::info('Result success? ' . json_encode($result));

        if ($result) {
            session()->flash('status', $message);
            $this->redirectRoute('product.form', ['hashed' => $this->form->product->hashed]);
        }
    }

    public function deleteImageConfirm() {
        $this->confirmAlert('warning', 'Apakah Anda yakin?', [
            'text' => 'Data yang terhapus akan hilang selamanya!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'showDenyButton' => true,
            'denyButtonText' => 'Iya, hapus ini!',
            'onDenied' => 'delete_image',
        ]);
    }

    #[On('delete_image')]
    public function delete_image() {
        if (isset($this->form->product) && $this->form->deleteImage()) {
            $message = 'Data berhasil dihapus!';
            $this->alert('success', $message);
        } else {
            $message = 'Data gagal dihapus!';
            $this->alert('error', $message);
        }
    }

    public function loadProductTypeAttributes() {
        $productType = $this->form->product->productType;
        if ($productType) {
            $this->availableAttributes = $productType->attributes;
        }
    }
}
