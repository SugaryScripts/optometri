<?php

namespace App\Helper;

use Vinkla\Hashids\Facades\Hashids;

trait HasHashid {
    // Accessor to get the encoded ID
    public function getHashedAttribute(): string {
        return Hashids::encode($this->id);
    }

    // Resolve model using encoded ID (for route model binding)
    public function resolveRouteBinding($value, $field = null) {
        $decoded = Hashids::decode($value);
        $id = $decoded[0] ?? null;

        return $id ? $this->where($field ?? 'id', $id)->first() : null;
    }

    // Scope to find a model by encoded ID
    public function scopeFindByHashed($query, $hashid) {
        $decoded = Hashids::decode($hashid);
        $id = $decoded[0] ?? null;

        return $query->where('id', $id);
    }

    // Static method to find by hashid or fail
    public static function findByHashedOrFail($hashid) {
        $decoded = Hashids::decode($hashid);
        $id = $decoded[0] ?? null;

        if (!$id) {
            throw (new ModelNotFoundException)->setModel(static::class);
        }

        return static::findOrFail($id);
    }
}
