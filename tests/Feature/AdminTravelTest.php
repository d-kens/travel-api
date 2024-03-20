<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTravelTest extends TestCase
{
    use RefreshDatabase;

    /*
    * Test Cases
      1. Public user cannot add travel
      2. Non admin user cannot add travel
      3. Admin can add travel
    */

    public function test_public_user_cannot_access_adding_travel(): void
    {
        $response = $this->postJson('/api/travels');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_cannot_access_adding_travel():void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/travels');

        $response->assertStatus(403);
    }

    public function test_saves_travel_successfully_with_valid_data():void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/travels', [
            'name' => 'Travel name',
        ]);

        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/travels', [
            'name' => 'Travel name',
            'is_public' => 1,
            'description' => 'Another travel description',
            'number_of_days' => 5
        ]);

        $response->assertStatus(201);

        $response = $this->get('/api/travels');
        $response->assertJsonFragment(['name' => 'Travel name']);
    }
}
