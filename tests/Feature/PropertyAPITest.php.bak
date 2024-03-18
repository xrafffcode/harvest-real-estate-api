<?php

namespace Tests\Feature\API\PropertyAPI;

use App\Models\Agent;
use App\Models\FloorPlan;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyCategory;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyAPITest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_property_api_call_store_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->make()
            ->toArray();

        $property['property_amenities'] = PropertyAmenity::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();
        $property['property_categories'] = PropertyCategory::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();
        $property['property_types'] = PropertyType::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();

        $propertyImageCount = mt_rand(1, 3);
        $propertyImages = PropertyImage::factory()->count($propertyImageCount)->make()->toArray();
        $property['property_images'] = $propertyImages;

        $floorPlanCount = mt_rand(1, 3);
        $floorPlans = FloorPlan::factory()->count($floorPlanCount)->make()->toArray();
        $property['property_floor_plans'] = $floorPlans;

        $api = $this->json('POST', '/api/v1/property', $property);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', Arr::except($property, [
            'property_amenities',
            'property_categories',
            'property_types',
            'property_images',
            'property_floor_plans',
        ]));
    }

    public function test_property_api_call_index_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $properties = Property::factory()
            ->for(Agent::factory()->create())
            ->hasAttached(PropertyAmenity::inRandomOrder()->first())
            ->hasAttached(PropertyCategory::inRandomOrder()->first())
            ->hasAttached(PropertyType::inRandomOrder()->first())
            ->has(PropertyImage::factory()->count(mt_rand(1, 3)))
            ->has(FloorPlan::factory()->count(mt_rand(1, 3)))
            ->count(5)
            ->create();

        $api = $this->json('GET', '/api/v1/properties');

        $api->assertSuccessful();

        foreach ($properties as $property) {
            $this->assertDatabaseHas('properties', $property->toArray());
        }
    }

    public function test_property_api_call_show_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('GET', '/api/v1/property/'.$property->id);

        $api->assertSuccessful();

        $api->assertJsonFragment($property->toArray());
    }

    public function test_property_api_call_get_property_by_slug_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('GET', '/api/v1/property/by-slug/'.$property->slug);

        $api->assertSuccessful();

        $api->assertJsonFragment($property->toArray());
    }

    public function test_property_api_call_get_property_cities_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $properties = Property::factory()
            ->for(Agent::factory()->create())
            ->count(5)
            ->create();

        $api = $this->json('GET', '/api/v1/properties/cities');

        $api->assertSuccessful();

        foreach ($properties as $property) {
            $this->assertDatabaseHas('properties', $property->toArray());
        }
    }

    public function test_property_api_call_get_properties_by_params_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $properties = Property::factory()
            ->for(Agent::factory()->create())
            ->count(5)
            ->create();

        $api = $this->json('GET', '/api/v1/properties/search');

        $api->assertSuccessful();

        foreach ($properties as $property) {
            $this->assertDatabaseHas('properties', $property->toArray());
        }
    }

    public function test_property_api_call_update_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $propertyUpdate = Property::factory()
            ->for(Agent::factory()->create())
            ->make()
            ->toArray();

        $propertyUpdate['property_amenities'] = PropertyAmenity::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();
        $propertyUpdate['property_categories'] = PropertyCategory::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();
        $propertyUpdate['property_types'] = PropertyType::inRandomOrder()->take(mt_rand(1, 3))->pluck('id')->toArray();

        $propertyImageCount = mt_rand(1, 3);
        $propertyImages = PropertyImage::factory()->count($propertyImageCount)->make()->toArray();
        $propertyUpdate['property_images'] = $propertyImages;

        $floorPlanCount = mt_rand(1, 3);
        $floorPlans = FloorPlan::factory()->count($floorPlanCount)->make()->toArray();
        $propertyUpdate['property_floor_plans'] = $floorPlans;

        $api = $this->json('POST', '/api/v1/property/'.$property->id, $propertyUpdate);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', Arr::except($propertyUpdate, [
            'property_amenities',
            'property_categories',
            'property_types',
            'property_images',
            'property_floor_plans',
        ]));

        foreach ($propertyUpdate['property_amenities'] as $propertyAmenity) {
            $this->assertDatabaseHas('property_amenity_pivot', [
                'property_id' => $property['id'],
                'property_amenity_id' => $propertyAmenity,
            ]);
        }

        foreach ($propertyUpdate['property_categories'] as $propertyCategory) {
            $this->assertDatabaseHas('property_category_pivot', [
                'property_id' => $property['id'],
                'property_category_id' => $propertyCategory,
            ]);
        }

        foreach ($propertyUpdate['property_types'] as $propertyType) {
            $this->assertDatabaseHas('property_type_pivot', [
                'property_id' => $property['id'],
                'property_type_id' => $propertyType,
            ]);
        }

        $propertyUpdate['property_images'] = $api['data']['property_images'];
        foreach ($propertyUpdate['property_images'] as $propertyImage) {
            $this->assertDatabaseHas('property_images', Arr::except($propertyImage, ['image_url']));

            $this->assertTrue(Storage::disk('public')->exists($propertyImage['image']));
        }

        $propertyUpdate['property_floor_plans'] = $api['data']['property_floor_plans'];
        foreach ($propertyUpdate['property_floor_plans'] as $floorPlan) {
            $this->assertDatabaseHas('floor_plans', Arr::except($floorPlan, ['image_url']));

            $this->assertTrue(Storage::disk('public')->exists($floorPlan['image']));
        }
    }

    public function test_property_api_call_update_featured_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/featured', ['is_featured' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_featured' => true]));
    }

    public function test_property_api_call_update_unfeatured_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/featured', ['is_featured' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_featured' => false]));
    }

    public function test_property_api_call_update_active_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/active', ['is_active' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_active' => 1]));
    }

    public function test_property_api_call_update_inactive_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/active', ['is_active' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_active' => false]));
    }

    public function test_property_api_call_update_sold_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/sold', ['is_sold' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_sold' => true]));
    }

    public function test_property_api_call_update_unsold_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/sold', ['is_sold' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_sold' => false]));
    }

    public function test_property_api_call_update_rented_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/rented', ['is_rented' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_rented' => true]));
    }

    public function test_property_api_call_update_unrented_property_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('POST', '/api/v1/property/'.$property->id.'/rented', ['is_rented' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('properties', array_merge($property->toArray(), ['is_rented' => false]));
    }

    public function test_property_api_call_delete_expect_successful()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($user);

        PropertyAmenity::factory()->count(5)->create();
        PropertyCategory::factory()->count(5)->create();
        PropertyType::factory()->count(5)->create();

        $property = Property::factory()
            ->for(Agent::factory()->create())
            ->create();

        $api = $this->json('DELETE', '/api/v1/property/'.$property->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted('properties', $property->toArray());
    }
}
