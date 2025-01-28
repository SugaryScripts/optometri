<?php

namespace App\Models;

use App\Helper\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model {
    use HasFactory;
    use HasHashid;

    protected $fillable = ['name', 'description'];

    /**
     * Get all attributes associated with this product type.
     */
    public function attributes(): HasMany {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * Get all products of this product type.
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

}
