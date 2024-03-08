<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price'
    ];


    /*
    Tour prices
        - are integer multipled by 100.
        - Example: 999 will 99900 but when returned to Frontends, they will be formated (99900 / 100)
    */


    // An accessor transforms an Eloquent attribute value when it is accessed
    // A mutator transforms an Eloquent attribute when it is set

   protected function price(): Attribute
   {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
   }

}
