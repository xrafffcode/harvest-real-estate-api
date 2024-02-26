<?php

namespace App\Repositories;

use App\Interfaces\PropertyTypeRepositoryInterface;
use App\Models\PropertyType;

class PropertyTypeRepository implements PropertyTypeRepositoryInterface
{
    public function getAllPropertyTypes()
    {
        return PropertyType::all();
    }

    public function createPropertyType(array $data)
    {
        return PropertyType::create($data);
    }

    public function getPropertyTypeById(string $id)
    {
        return PropertyType::findOrFail($id);
    }

    public function updatePropertyType(array $data, string $id)
    {
        return $this->getPropertyTypeById($id)->update($data);
    }

    public function deletePropertyType(string $id)
    {
        return $this->getPropertyTypeById($id)->delete();
    }
}
