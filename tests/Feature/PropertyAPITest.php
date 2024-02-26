<?php

namespace Tests\Feature\API\PropertyAPI;

use App\Models\Agent;
use App\Models\FloorPlan;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use App\Models\User;
use Tests\TestCase;

class PropertyAPITest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_property_api_call_store_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);
        $user['password'] = $password;

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $agent = Agent::factory()->create();

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $FloorPlanCount = mt_rand(1, 3);
        $anu = FloorPlan::factory()->count($FloorPlanCount)->make()->toArray();

        $property = Property::factory()->for($agent)->make()->toArray();

        $api = $this->json('POST', 'api/v1/property/property/store', $property);

        $api->assertSuccessful();
        $this->assertDatabaseHas('properties', [
            'code' => $property['code'],
            'area' => $property['area'],
            'title' => $property['title'],
            'description' => $property['description'],
            'loc_city' => $property['loc_city'],
            'loc_latitude' => $property['loc_latitude'],
            'loc_longitude' => $property['loc_longitude'],
            'loc_address' => $property['loc_address'],
            'loc_neighborhood' => $property['loc_neighborhood'],
            'loc_zip' => $property['loc_zip'],
            'loc_country' => $property['loc_country'],
            'price' => $property['price'],
            'price_label' => $property['price_label'],
            'agent_id' => $property['agent_id'],
        ]);
    }
}
