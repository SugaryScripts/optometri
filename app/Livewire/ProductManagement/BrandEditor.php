<?php

namespace App\Livewire\ProductManagement;

use App\Helper\HandlesSafeDbOperations;
use App\Livewire\BaseComponent;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandEditor extends BaseComponent {
    use WithFileUploads;

    public BrandForm $form;

    public function mount(string $hashed = '') {
        if ($hashed) {
            $data = \App\Models\Brand::findByHashedOrFail($hashed);
            $this->form->setData($data);
        }
    }

    public function render() {
        return view('product-management.brand-editor');
    }

    public function save() {
        if (isset($this->form->brand)){
            $result = $this->form->update();
            $message = 'Data updated successfully';
            Debugbar::info($message);
        }else {
            $result = $this->form->store();
            $message = 'Data created successfully';
            Debugbar::info($message);
        }
        Debugbar::info('Result success? ' . json_encode($result));

        if ($result){
            session()->flash('status', $message);
            $this->redirectRoute('brand');
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
    public function delete_image(){
        if (isset($this->form->brand) && $this->form->deleteImage()){
            $message = 'Data berhasil dihapus!';
            $this->alert('success', $message);
        }else {
            $message = 'Data gagal dihapus!';
            $this->alert('error', $message);
        }
    }
}
