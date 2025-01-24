<?php

namespace App\Livewire\Catalog;

use App\Helper\UploadHelper;
use Livewire\Attributes\On;
use Livewire\Component;

class BrandModal extends Component {
    public ?\App\Models\Brand $brand;
    public ?string $filename = null;

    public function render() {
        return view('catalog.brand-modal');
    }

    #[On('getData')]
    public function getData($userId) {
        $this->brand = \App\Models\Brand::findByHashedOrFail($userId);
        $this->filename = UploadHelper::getUploadedFile(config('file_path.brand'), $this->brand->hashed,  $this->brand->image_filename);

        $this->dispatch('showModal');
    }

    #[On('clearVars')]
    public function clearVars(){
        $this->brand = null;
    }

}
