<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_filename',
        'image_original_name',
    ];

    /**
     * Get all products associated with this brand.
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
