<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Jetstream\HasProfilePhoto;

class Staff extends Model {
    use HasFactory;
    use HasProfilePhoto;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone',
        'address',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }
}
