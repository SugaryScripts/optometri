<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Livewire\Component;

class TypeEditor extends BaseComponent {
    public TypeForm $form;
    public $selectedId;

    protected $listeners = [
        'closeModal' => '$refresh',
    ];

    public function mount(string $hashed = '') {
        if ($hashed) {
            $data = \App\Models\ProductType::findByHashedOrFail($hashed);
            $this->form->setData($data);
        }
        if (session()->has('status')) {
            $this->alert('success', 'Berhasil!', [
                'text' => session('status')
            ]);
        }
    }

    public function render() {
        return view('product-management.type-editor', [
            'attributes' => $this->form->type?->attributes ?? collect()
        ]);
    }

    public function save() {
        if (isset($this->form->type)) {
            $result = $this->form->update();
            $message = 'Data updated successfully';
            if ($result)
                $this->alert('success', 'Berhasil!', [
                    'text' => $message
                ]);
        } else {

            $result = $this->form->store();
            $message = 'Data created successfully';
            if ($result) {
                session()->flash('status', $message);
                $this->redirectRoute('type.form', ['hashed' => $this->form->type->hashed]);
            }
        }
        Debugbar::info('Result success? ' . json_encode($result));
    }


    public function deleteConfirm($id) {
        $this->selectedId = $id;
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
            'onDenied' => 'delete',
        ]);
    }


    #[On('delete')]
    public function delete() {
        $this->safeDbOperation(function () {
            $data = \App\Models\ProductAttribute::findByHashedOrFail($this->selectedId);
            $data->delete();
            $this->alert('success', 'Data berhasil dihapus!');
        });
    }

    public function selectItem($itemId) {
        $this->selectedId = $itemId;
        $this->dispatch('getData', $this->selectedId);
    }

    #[On('sessionFlash')]
    public function sessionFlash($message) {
        session()->flash('status', $message);
        $this->redirectRoute('type.form', ['hashed' => $this->form->type->hashed]);
        // TODO: Fix alert create
    }

}
