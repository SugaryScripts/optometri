<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = [
        'original_name',
        'file_name',
        'is_cover',
        'product_id'
    ];

    // A ProductImage belongs to one Product
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($image) {
            if ($image->is_cover) {
                ProductImage::where('product_id', $image->product_id)
                    ->update(['is_cover' => false]);
            }
        });

        static::updating(function ($image) {
            if ($image->is_cover) {
                ProductImage::where('product_id', $image->product_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_cover' => false]);
            }
        });
    }
}
