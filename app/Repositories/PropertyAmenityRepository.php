<?php

namespace App\Repositories;

use App\Interfaces\PropertyAmenityRepositoryInterface;
use App\Models\PropertyAmenity;

class PropertyAmenityRepository implements PropertyAmenityRepositoryInterface
{
    public function getAllPropertyAmenities()
    {
        return PropertyAmenity::all();
    }

    public function getPropertyAmenityById($id)
    {
        return PropertyAmenity::find($id);
    }

    public function create($data)
    {
        $propertyAmenity = new PropertyAmenity();
        $propertyAmenity->fill($data);
        $propertyAmenity->save();

        return $propertyAmenity;
    }

    public function update($data, $id)
    {
        $propertyAmenity = PropertyAmenity::find($id);
        $propertyAmenity->fill($data);
        $propertyAmenity->save();

        return $propertyAmenity;
    }

    public function delete($id)
    {
        return PropertyAmenity::destroy($id);
    }
}
