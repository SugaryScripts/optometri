<?php

namespace App\Livewire\Home;

use App\Models\Product;
use Livewire\Component;

class CatalogDetail extends Component {

    public Product $product;
    public $selectedVariant = null;
    public $activeImageIndex = 0;

    public function mount($hashed) {
        $product = Product::findByHashedOrFail($hashed);
        $this->product = $product->load([
            'productType',
            'brand',
            'attributeValues.productAttribute',
            'variants.attributeValues.productAttribute',
            'images',
            'productType.attributes'
        ]);

        // Set first variant as default selected if exists
        if ($this->product->variants->isNotEmpty()) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
    }

    // Group attributes by their purpose (product or variant level)
    public function getGroupedAttributesProperty() {
        $productTypeAttributes = $this->product->productType->attributes;

        $productAttributes = $productTypeAttributes->filter(function ($attribute) {
            return $this->product->attributeValues
                ->where('product_attribute_id', $attribute->id)
                ->isNotEmpty();
        });

        $variantAttributes = $productTypeAttributes->filter(function ($attribute) {
            return $this->product->variants
                ->flatMap->attributeValues
                ->where('product_attribute_id', $attribute->id)
                ->isNotEmpty();
        });

        return [
            'product' => $productAttributes,
            'variant' => $variantAttributes
        ];
    }

    public function render() {
        return view('home.catalog-detail');
    }
}
