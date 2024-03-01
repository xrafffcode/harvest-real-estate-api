<?php

namespace App\Repositories;

use App\Interfaces\PropertyRepositoryInterface;
use App\Models\FloorPlan;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function getAllProperties(string $sortBy = null, string $sort = null)
    {
        $properties = Property::with(['propertyAmenities', 'propertyCategories', 'propertyTypes', 'propertyImages', 'floorPlans']);

        if ($sortBy && $sort) {
            return $properties->orderBy($sortBy, $sort)->get();
        }

        return $properties->orderBy('is_featured', 'desc')->get();
    }

    public function getPropertiesByParams(string $search = null, string $city = null, string $category = null, string $amenities = null, string $type = null, int $minPrice = null, int $maxPrice = null, bool $sold = null, bool $rented = null)
    {
        $properties = Property::query();

        $properties->where(function ($query) use ($search, $city, $category, $amenities, $type, $minPrice, $maxPrice, $sold, $rented) {

            if ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%'.$search.'%')
                        ->orWhere('loc_city', 'like', '%'.$search.'%')
                        ->orWhere('loc_state', 'like', '%'.$search.'%')
                        ->orWhere('loc_address', 'like', '%'.$search.'%')
                        ->orWhere('offer_type', 'like', '%'.$search.'%');
                });
            }

            if ($city) {
                $query->where('loc_city', 'like', '%'.$city.'%');
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

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $property = new Property();
            $property->title = $data['title'];
            $property->description = $data['description'];
            $property->loc_city = $data['loc_city'];
            $property->loc_latitude = $data['loc_latitude'];
            $property->loc_longitude = $data['loc_longitude'];
            $property->loc_address = $data['loc_address'];
            $property->loc_state = $data['loc_state'];
            $property->loc_zip = $data['loc_zip'];
            $property->loc_country = $data['loc_country'];
            $property->price = $data['price'];
            $property->agent_id = $data['agent_id'];
            $property->is_featured = $data['is_featured'];
            $property->is_active = $data['is_active'];
            $property->is_sold = $data['is_sold'];
            $property->is_rented = $data['is_rented'];
            $property->offer_type = $data['offer_type'];
            $property->slug = $data['slug'];
            $property->save();

            $property->propertyAmenities()->attach($data['property_amenities']);

            $property->propertyCategories()->attach($data['property_categories']);

            $property->propertyTypes()->attach($data['property_types']);

            if (isset($data['property_images'])) {
                foreach ($data['property_images'] as $image) {
                    $propertyImage = new PropertyImage();
                    $propertyImage->property_id = $property->id;
                    $propertyImage->image = $image['image']->store('assets/properties/images', 'public');
                    $propertyImage->save();
                }
            }

            if (isset($data['property_floor_plans'])) {
                foreach ($data['property_floor_plans'] as $floorPlan) {
                    $propertyFloorPlan = new FloorPlan();
                    $propertyFloorPlan->property_id = $property->id;
                    $propertyFloorPlan->sort = $floorPlan['sort'];
                    $propertyFloorPlan->title = $floorPlan['title'];
                    $propertyFloorPlan->image = $floorPlan['image']->store('assets/properties/floor_plans', 'public');
                    $propertyFloorPlan->save();
                }
            }

            DB::commit();

            return $property;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        $property = Property::find($id);

        $property->title = $data['title'];
        $property->description = $data['description'];
        $property->loc_city = $data['loc_city'];
        $property->loc_latitude = $data['loc_latitude'];
        $property->loc_longitude = $data['loc_longitude'];
        $property->loc_address = $data['loc_address'];
        $property->loc_state = $data['loc_state'];
        $property->loc_zip = $data['loc_zip'];
        $property->loc_country = $data['loc_country'];
        $property->price = $data['price'];
        $property->agent_id = $data['agent_id'];
        $property->is_featured = $data['is_featured'];
        $property->is_active = $data['is_active'];
        $property->is_sold = $data['is_sold'];
        $property->is_rented = $data['is_rented'];
        $property->offer_type = $data['offer_type'];
        $property->slug = $data['slug'];
        $property->save();

        $property->propertyAmenities()->sync($data['property_amenities']);

        $property->propertyCategories()->sync($data['property_categories']);

        $property->propertyTypes()->sync($data['property_types']);

        $existingImageIds = collect($property->propertyImages->pluck('id'));
        $newImageIds = collect($data['property_images'])->pluck('id')->filter();
        $deletedImageIds = $existingImageIds->diff($newImageIds);
        $property->propertyImages()->whereIn('id', $deletedImageIds)->delete();
        foreach ($data['property_images'] as $image) {
            if ($image['id']) {
                $propertyImage = PropertyImage::find($image['id']);
                $propertyImage->image = $image['image']->store('assets/properties/images', 'public');
                $propertyImage->save();
            } else {
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $property->id;
                $propertyImage->image = $image['image']->store('assets/properties/images', 'public');
                $propertyImage->save();
            }
        }

        $existingFloorPlanIds = collect($property->floorPlans->pluck('id'));
        $newFloorPlanIds = collect($data['property_floor_plans'])->pluck('id')->filter();
        $deletedFloorPlanIds = $existingFloorPlanIds->diff($newFloorPlanIds);
        $property->floorPlans()->whereIn('id', $deletedFloorPlanIds)->delete();
        foreach ($data['property_floor_plans'] as $floorPlan) {
            if ($floorPlan['id']) {
                $propertyFloorPlan = FloorPlan::find($floorPlan['id']);
                $propertyFloorPlan->sort = $floorPlan['sort'];
                $propertyFloorPlan->title = $floorPlan['title'];
                $propertyFloorPlan->image = $floorPlan['image']->store('assets/properties/floor_plans', 'public');
                $propertyFloorPlan->save();
            } else {
                $propertyFloorPlan = new FloorPlan();
                $propertyFloorPlan->property_id = $property->id;
                $propertyFloorPlan->sort = $floorPlan['sort'];
                $propertyFloorPlan->title = $floorPlan['title'];
                $propertyFloorPlan->image = $floorPlan['image']->store('assets/properties/floor_plans', 'public');
                $propertyFloorPlan->save();
            }
        }

        DB::commit();

        return $property->refresh();
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

    public function delete($id)
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
