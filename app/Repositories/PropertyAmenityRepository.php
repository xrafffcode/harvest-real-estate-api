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

    public function createPropertyAmenity($data)
    {
        return PropertyAmenity::create($data);
    }

    public function updatePropertyAmenity($data, $id)
    {
        return PropertyAmenity::find($id)->update($data);
    }

    public function deletePropertyAmenity($id)
    {
        return PropertyAmenity::destroy($id);
    }
}
