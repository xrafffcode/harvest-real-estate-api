<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\FloorPlan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FloorPlanAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_floor_plan_api_call_create_expect_success()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        $agent = Agent::factory()->create();

        $property = Property::factory()
            ->for($agent)
            ->create();

        $floorPlan = FloorPlan::factory()
            ->for($property)
            ->make()
            ->toArray();

        $api = $this->json('POST', '/api/v1/floor_plan', $floorPlan);

        $api->assertSuccessful();

        $floorPlan['image'] = $api['data']['image'];

        $this->assertDatabaseHas('floor_plans', $floorPlan);

        $this->assertTrue(Storage::disk('public')->exists($floorPlan['image']));
    }

    public function test_floor_plan_api_call_read_expect_collection()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        $agent = Agent::factory()->create();

        $property = Property::factory()
            ->for($agent)
            ->create();

        $floorPlans = FloorPlan::factory()
            ->for($property)
            ->count(5)
            ->create();

        $api = $this->json('GET', '/api/v1/floor_plans');

        $api->assertSuccessful();

        foreach ($floorPlans as $floorPlan) {
            $this->assertDatabaseHas('floor_plans', $floorPlan->toArray());
        }
    }

    public function test_floor_plan_api_call_get_floor_plan_by_id_expect_success()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        $agent = Agent::factory()->create();

        $property = Property::factory()
            ->for($agent)
            ->create();

        $floorPlan = FloorPlan::factory()
            ->for($property)
            ->create();

        $api = $this->json('GET', '/api/v1/floor_plan/'.$floorPlan->id);

        $api->assertSuccessful();

        $this->assertDatabaseHas('floor_plans', $floorPlan->toArray());
    }

    public function test_floor_plan_api_call_update_expect_success()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        $agent = Agent::factory()->create();

        $property = Property::factory()
            ->for($agent)
            ->create();

        $floorPlan = FloorPlan::factory()
            ->for($property)
            ->create();

        $updatedFloorPlan = FloorPlan::factory()
            ->for($property)
            ->make()
            ->toArray();

        $api = $this->json('POST', '/api/v1/floor_plan/'.$floorPlan->id, $updatedFloorPlan);

        $api->assertSuccessful();

        $updatedFloorPlan['image'] = $api['data']['image'];

        $this->assertDatabaseHas('floor_plans', $updatedFloorPlan);

        $this->assertTrue(Storage::disk('public')->exists($updatedFloorPlan['image']));
    }

    public function test_floor_plan_api_call_delete_expect_success()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        $agent = Agent::factory()->create();

        $property = Property::factory()
            ->for($agent)
            ->create();

        $floorPlan = FloorPlan::factory()
            ->for($property)
            ->create();

        $api = $this->json('DELETE', '/api/v1/floor_plan/'.$floorPlan->id);

        $api->assertSuccessful();

        $this->assertDatabaseMissing('floor_plans', $floorPlan->toArray());

        $this->assertFalse(Storage::disk('public')->exists($floorPlan->image));
    }
}
