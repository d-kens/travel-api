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
        // http://127.0.0.1:8000/api/v1/travels?page=2&page_size=2 -> Request Example
        $travels = Travel::query()->where('is_public', true)->paginate( $request->page_size ?? 15);


        return TravelResource::collection($travels);
    }

    public function store(TravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }


    /*

        By calling the validated() method on the $request object,
        Laravel will automatically validate the incoming request data against the rules defined in the corresponding form request class.

    */
}
