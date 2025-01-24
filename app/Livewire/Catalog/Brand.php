<?php

namespace App\Livewire\Catalog;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Brand extends BaseComponent {
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

    public function mount() {
        if (session()->has('status')) {
            $this->alert('success', 'Berhasil!', [
                'text' => session('status')
            ]);
        }
    }

    public function render() {
        return view('catalog.brand', [
            'data' => $this->fetchData()
        ]);
    }

    private function fetchData() {
        return \App\Models\Brand::where(function ($query) {
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
            $data = \App\Models\Brand::findByHashedOrFail($this->selectedId);
            $filepath = config('file_path.brand') . $this->selectedId;
            Storage::disk('public')->deleteDirectory($filepath);
            $data->delete();

            $this->alert('success', 'Data berhasil dihapus!');
        });
    }

    public function selectItem($itemId) {
        $this->selectedId = $itemId;
        $this->dispatch('getData', $this->selectedId);
    }
}
