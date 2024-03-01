<?php

namespace App\Repositories;

use App\Interfaces\PropertyTypeRepositoryInterface;
use App\Models\PropertyType;
use Illuminate\Support\Str;

class PropertyTypeRepository implements PropertyTypeRepositoryInterface
{
    public function getAllPropertyTypes()
    {
        return PropertyType::all();
    }

    public function create(array $data)
    {
        $propertyType = new PropertyType;
        $propertyType->name = $data['name'];
        $propertyType->slug = $data['slug'];
        $propertyType->save();

        return $propertyType;
    }

    public function getPropertyTypeById(string $id)
    {
        return PropertyType::findOrFail($id);
    }

    public function update(array $data, string $id)
    {
        $propertyType = $this->getPropertyTypeById($id);
        $propertyType->name = $data['name'];
        $propertyType->slug = $data['slug'];
        $propertyType->save();

        return $propertyType;
    }

    public function delete(string $id)
    {
        return $this->getPropertyTypeById($id)->delete();
    }

    public function generateSlug(string $name, int $tryCount): string
    {
        $slug = Str::slug($name);

        if ($tryCount > 0) {
            $slug = $slug.'_'.$tryCount;
        }

        return $slug;
    }

    public function isUniqueSlug(string $slug, string $exceptId = null): bool
    {
        if (PropertyType::count() === 0) {
            return true;
        }

        $query = PropertyType::where('slug', $slug);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->count() === 0;
    }
}
