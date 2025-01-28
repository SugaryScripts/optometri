<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductVariant extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = ['sku', 'price', 'product_id'];

    /**
     * Get the product this variant belongs to.
     */
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all attribute values associated with this variant.
     */
    public function attributeValues(): MorphMany {
        return $this->morphMany(ProductAttributeValue::class, 'attributable');
    }
}
