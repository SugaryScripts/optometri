<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = ['name', 'description', 'sku', 'price', 'product_type_id'];

    /**
     * Get the product type this product belongs to.
     */
    public function productType(): BelongsTo {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get the brand this product belongs to (if any).
     */
    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all attribute values associated with this product.
     */
    public function attributeValues(): MorphMany {
        return $this->morphMany(ProductAttributeValue::class, 'attributable');
    }

    /**
     * Get all variants for this product.
     */
    public function variants(): HasMany {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany {
        return $this->hasMany(ProductImage::class);
    }

    // Get the cover image (the main image for the product)
    public function coverImage(): HasOne {
        return $this->hasOne(ProductImage::class)->where('is_cover', true);
    }
}
