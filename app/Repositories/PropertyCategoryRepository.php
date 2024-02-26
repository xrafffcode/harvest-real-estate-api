<?php

namespace App\Repositories;

use App\Interfaces\PropertyCategoryRepositoryInterface;
use App\Models\PropertyCategory;

class PropertyCategoryRepository implements PropertyCategoryRepositoryInterface
{
    public function getAllPropertyCategories()
    {
        return PropertyCategory::all();
    }

    public function createPropertyCategory(array $data)
    {
        return PropertyCategory::create($data);
    }

    public function getPropertyCategoryById(string $id)
    {
        return PropertyCategory::find($id);
    }

    public function updatePropertyCategory(array $data, string $id)
    {
        return $this->getPropertyCategoryById($id)->update($data);
    }

    public function deletePropertyCategory(string $id)
    {
        return $this->getPropertyCategoryById($id)->delete();
    }
}
