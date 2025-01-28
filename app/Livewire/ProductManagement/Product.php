<?php

namespace App\Livewire\ProductManagement;

use App\Livewire\BaseComponent;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Product extends BaseComponent {
    use WithPagination, WithoutUrlPagination;

    public $selectedId = -1;
    public $paginate_item = 10, $search, $sortColumn = 'updated_at', $sortDirection = 'desc';

    public function search(){
        $this->resetPage();
    }

    public function sort($column) {
        $this->sortDirection = $this->sortColumn == $column ?  ($this->sortDirection == 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortColumn = $column;
        $this->alert('info', 'Data tersortir');
    }

    public function render() {
        return view('product-management.product', [
            'data' => $this->fetchData()
        ]);
    }

    private function fetchData() {
        return \App\Models\Product::where(function ($query) {
            if ($this->search != '') {
                $query->where('name', 'like', '%'.$this->search.'%');
                $query->orWhere('description', 'like', '%'.$this->search.'%');
            }
        })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->paginate_item)->onEachSide(1);
    }

    public function deleteConfirm($id){
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
    public function delete(){
        $this->safeDbOperation(function () {
            $data = \App\Models\Product::findByHashedOrFail($this->selectedId);
            $data->delete();

            $this->alert('success', 'Data berhasil dihapus!');
        });
    }
}
