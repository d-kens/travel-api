<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Travel;

class TravelController extends Controller
{
    use RefreshDatabase;

    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate();
        return TravelResource::collection($travels);
    }
}