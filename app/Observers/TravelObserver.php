<?php

namespace App\Observers;

use App\Models\Travel;

class TravelObserver
{

    public function creating(Travel $travel): void
    {
        $travel->slug = str($travel->name)->slug();
    }


    // TODO: Make the slugs unique
}
