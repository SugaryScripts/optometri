<?php

namespace App\Livewire\Home;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Catalog extends Component {
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $selectedBrands = [];
    public $selectedTypes = [];
    public $minPrice;
    public $maxPrice;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 12;

    // Available brands and types for filters
    public $brands;
    public $productTypes;


    protected $queryString = [
        'search' => ['except' => ''],
        'selectedBrands' => ['except' => []],
        'selectedTypes' => ['except' => []],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 12]
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function updatingSelectedBrands() {
        $this->resetPage();
    }

    public function updatingSelectedTypes() {
        $this->resetPage();
    }

    public function updatingMinPrice() {
        $this->resetPage();
    }

    public function updatingMaxPrice() {
        $this->resetPage();
    }

    public function sortBy($field) {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters() {
        $this->reset([
            'search',
            'selectedBrands',
            'selectedTypes',
            'minPrice',
            'maxPrice',
            'sortBy',
            'sortDirection'
        ]);
    }

    public function mount() {
        $this->brands = Brand::orderBy('name')->get();
        $this->productTypes = ProductType::orderBy('name')->get();
    }

    public function render() {
        return view('home.catalog', [
            'products' => $this->fetchData()
        ]);
    }

    public function fetchData() {
        return Product::query()
            ->with(['brand', 'productType', 'coverImage'])
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedBrands, function (Builder $query) {
                $query->whereIn('brand_id', $this->selectedBrands);
            })
            ->when($this->selectedTypes, function (Builder $query) {
                $query->whereIn('product_type_id', $this->selectedTypes);
            })
            ->when($this->minPrice, function (Builder $query) {
                $query->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function (Builder $query) {
                $query->where('price', '<=', $this->maxPrice);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
