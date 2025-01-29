<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = ['name', 'data_type', 'required', 'product_type_id'];

    /**
     * Get the product type this attribute belongs to.
     */
    public function productType(): BelongsTo {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get all values for this attribute.
     */
    public function attributeValues(): HasMany {
        return $this->hasMany(ProductAttributeValue::class);
    }

    // New relationship for products using this attribute as variant
    public function variantProducts(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_variant_attributes')
            ->withTimestamps();
    }
}
