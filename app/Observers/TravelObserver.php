<?php

namespace App\Observers;

use App\Models\Travel;
use Illuminate\Support\Str;


class TravelObserver
{
    public function creating(Travel $travel): void
    {
        $baseSlug = Str::slug($travel->name);
        $slug = $baseSlug;
        $count = 1;

        while (Travel::where('slug', $slug)->exists()) {
            $slug = $baseSlug . "-" . $count;
            $count++;
        }

        $travel->slug = $slug;
    }
}
