<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductAttributeValue extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = ['value', 'product_attribute_id', 'attributable_type', 'attributable_id'];

    /**
     * Get the attribute associated with this value.
     */
    public function productAttribute(): BelongsTo {
        return $this->belongsTo(ProductAttribute::class);
    }

    /**
     * Get the product or variant this value is associated with.
     */
    public function attributable(): MorphTo {
        return $this->morphTo();
    }
}
