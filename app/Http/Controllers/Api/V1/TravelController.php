<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    use RefreshDatabase;

    public function index(Request $request)
    {
        $travels = Travel::query()->where('is_public', true)->paginate( $request->page_size ?? 15);
        return TravelResource::collection($travels);
    }

    /*
        By calling the validated() method on the request object, Laravel will automatically
        validate the incoming request data against the rules defined in the corresponding for request class
    */
    public function store(TravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

}
