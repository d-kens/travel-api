<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelsListTest extends TestCase
{
    use RefreshDatabase;

    // http://127.0.0.1:8000/api/v1/travels?page=2&page_size=2

    public function test_travel_list_returns_paginated_data_correctly_15_per_page(): void
    {
        Travel::factory(47)->create(['is_public' => true]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);

        $response->assertJsonCount(15, 'data');

        $response->assertJsonPath('meta.last_page', 4);
    }

    public function test_travel_list_returns_paginated_data_correctly_with_specified_page_number_and_page_size(): void
    {
        Travel::factory(47)->create(['is_public' => true]);

        $page = 2;
        $page_size = 10;

        $response = $this->get('api/v1/travels?page='.$page.'&page_size='.$page_size);

        $response->assertStatus(200);

        $response->assertJsonCount($page_size, 'data');

        $response->assertJsonPath('meta.current_page', 2);

        $response->assertJsonPath('meta.from', 11);

        $response->assertJsonPath('meta.to', 20);

        $response->assertJsonPath('meta.last_page', 5);
    }


    public function test_travel_list_shows_only_public_records(): void
    {
        $publicTravel = Travel::factory()->create(['is_public' => true]);
        Travel::factory()->create(['is_public' => false]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');

        $response->assertJsonPath('data.0.name', $publicTravel->name);
    }



    // "meta": {
    //     "current_page": 2,
    //     "from": 11,
    //     "last_page": 5,
    //     "links": [
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=1",
    //         "label": "&laquo; Previous",
    //         "active": false
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=1",
    //         "label": "1",
    //         "active": false
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=2",
    //         "label": "2",
    //         "active": true
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=3",
    //         "label": "3",
    //         "active": false
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=4",
    //         "label": "4",
    //         "active": false
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=5",
    //         "label": "5",
    //         "active": false
    //       },
    //       {
    //         "url": "http://127.0.0.1:8000/api/v1/travels?page=3",
    //         "label": "Next &raquo;",
    //         "active": false
    //       }
    //     ],
    //     "path": "http://127.0.0.1:8000/api/v1/travels",
    //     "per_page": 10,
    //     "to": 20,
    //     "total": 47
    //   }




    // public function test_travel_list_shows_only_public_records(): void
    // {
    //     $publicTravel = Travel::factory()->create(['is_public' => true]);
    //     Travel::factory()->create(['is_public' => false]);

    //     $response = $this->get('/api/v1/travels');

    //     $response->assertStatus(200);

    //     $response->assertJsonCount(1, 'data');

    //     $response->assertJsonPath('data.0.name', $publicTravel->name);
    // }

}
