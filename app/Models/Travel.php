<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days'
    ];

    protected function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }


    // Number of nights (virtual, computed by `numberOfDays - 1`)
    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['number_of_days'] - 1
        );
    }
}
