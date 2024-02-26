<?php

namespace App\Repositories;

use App\Interfaces\PropertyRepositoryInterface;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function getAllProperties(?string $sortBy = null, ?string $sort = null)
    {
        if ($sortBy && $sort) {
            return Property::orderBy($sortBy, $sort)->get();
        }

        return Property::orderBy('is_featured', 'desc')->get();
    }

    public function getPropertiesByParams(?string $search = null, ?string $city = null, ?string $category = null, ?string $amenities = null, ?string $type = null, ?int $minPrice = null, ?int $maxPrice = null, ?bool $sold = null, ?bool $rented = null)
    {
        $properties = Property::query();

        $properties->where(function ($query) use ($search, $city, $category, $amenities, $type, $minPrice, $maxPrice, $sold, $rented) {

            if ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('loc_city', 'like', '%' . $search . '%')
                        ->orWhere('loc_state', 'like', '%' . $search . '%')
                        ->orWhere('loc_address', 'like', '%' . $search . '%')
                        ->orWhere('offer_type', 'like', '%' . $search . '%');
                });
            }

            if ($city) {
                $query->where('loc_city', 'like', '%' . $city . '%');
            }

            if ($category) {
                $query->whereHas('propertyCategories', function ($subQuery) use ($category) {
                    $subQuery->where('name', $category);
                });
            }

            if ($amenities) {
                $query->whereHas('propertyAmenities', function ($subQuery) use ($amenities) {
                    $subQuery->where('name', $amenities);
                });
            }


            if ($minPrice >= 0 && $maxPrice > 0) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }


            if ($sold) {
                $query->where('is_sold', $sold);
            }

            if ($rented) {
                $query->where('is_rented', $rented);
            }

            if ($type) {
                $query->where('offer_type', $type);
            }
        });

        return $properties->get();
    }


    public function getPropertyById($id)
    {
        return Property::find($id);
    }

    public function getPropertyBySlug($slug)
    {
        return Property::where('slug', $slug)->first();
    }

    public function getPropertyCities()
    {
        return Property::groupBy('loc_city')->select('loc_city', DB::raw('count(*) as total_properties'))->get();
    }

    public function createProperty($data)
    {

        DB::beginTransaction();

        $property = Property::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
            'loc_city' => $data['loc_city'],
            'loc_latitude' => $data['loc_latitude'],
            'loc_longitude' => $data['loc_longitude'],
            'loc_address' => $data['loc_address'],
            'loc_state' => $data['loc_state'],
            'loc_zip' => $data['loc_zip'],
            'loc_country' => $data['loc_country'],
            'price' => $data['price'],
            'agent_id' => $data['agent_id'],
            'is_featured' => $data['is_featured'],
        ]);

        $property->propertyAmenities()->attach($data['property_amenities']);

        $property->propertyCategories()->attach($data['property_categories']);


        foreach ($data['property_images'] as $image) {
            $property->propertyImages()->create([
                'image' => $image,
            ]);
        }

        if (isset($data['property_floor_plans'])) {
            foreach ($data['property_floor_plans'] as $index => $floorPlan) {
                $floorPlanData = json_decode($floorPlan, true);

                $newFloorPlan = $property->floorPlans()->create([
                    'sort' => $floorPlanData['sort'],
                    'title' => $floorPlanData['title'],
                ]);

                $image = $data['property_floor_plans_images'][$index];
                $newFloorPlan->update(['image' => $image->store('assets/properties/floor_plans', 'public')]);
            }
        }

        DB::commit();

        return $property;
    }

    public function updateProperty($data, $id)
    {
        DB::beginTransaction();

        $property = Property::find($id);

        $property->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
            'loc_city' => $data['loc_city'],
            'loc_latitude' => $data['loc_latitude'],
            'loc_longitude' => $data['loc_longitude'],
            'loc_address' => $data['loc_address'],
            'loc_state' => $data['loc_state'],
            'loc_zip' => $data['loc_zip'],
            'loc_country' => $data['loc_country'],
            'price' => $data['price'],
            'agent_id' => $data['agent_id'],
            'is_featured' => $data['is_featured'],
            'offer_type' => $data['offer_type'],
        ]);

        $property->propertyAmenities()->sync($data['property_amenities']);
        $property->propertyCategories()->sync($data['property_categories']);

        if (isset($data['property_images'])) {
            foreach ($data['property_images'] as $image) {
                if (is_uploaded_file($image)) {
                    $imageFile = $image;
                    $property->propertyImages()->create([
                        'image' => $imageFile->store('assets/properties/images', 'public'),
                    ]);
                }
            }
        }

        if (isset($data['property_floor_plans'])) {
            foreach ($data['property_floor_plans'] as $index => $floorPlan) {
                $floorPlanData = json_decode($floorPlan, true);

                $newFloorPlan = $property->floorPlans()->updateOrCreate([
                    'sort' => $floorPlanData['sort'],
                    'title' => $floorPlanData['title'],
                ]);

                if (isset($data['property_floor_plans_images'][$index]) && is_uploaded_file($data['property_floor_plans_images'][$index])) {
                    $image = $data['property_floor_plans_images'][$index];
                    $newFloorPlan->update(['image' => $image->store('assets/properties/floor_plans', 'public')]);
                }
            }
        }



        DB::commit();

        return $property;
    }

    public function updateFeaturedProperty($id, $featured)
    {
        $property = Property::find($id);

        $property->update([
            'is_featured' => $featured,
        ]);

        return $property;
    }

    public function updateActiveProperty($id, $active)
    {
        $property = Property::find($id);

        $property->update([
            'is_active' => $active,
        ]);

        return $property;
    }

    public function updateSoldProperty($id, $sold)
    {
        $property = Property::find($id);

        $property->update([
            'is_sold' => $sold,
        ]);

        return $property;
    }

    public function updateRentedProperty($id, $rented)
    {

        $property = Property::find($id);

        $property->update([
            'is_rented' => $rented,
        ]);

        return $property;
    }

    public function deleteProperty($id)
    {
        return Property::destroy($id);
    }

    public function deletePropertyImage($id)
    {
        $property = PropertyImage::find($id);

        $property->delete();

        return $property;
    }
}
