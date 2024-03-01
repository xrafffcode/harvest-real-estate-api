<?php

namespace App\Repositories;

use App\Interfaces\PropertyCategoryRepositoryInterface;
use App\Models\PropertyCategory;
use Illuminate\Support\Str;

class PropertyCategoryRepository implements PropertyCategoryRepositoryInterface
{
    public function getAllPropertyCategories()
    {
        return PropertyCategory::all();
    }

    public function create(array $data)
    {
        $category = new PropertyCategory();
        $category->name = $data['name'];
        $category->icon = $data['icon'];
        $category->slug = $data['slug'];
        $category->save();

        return $category;
    }

    public function getPropertyCategoryById(string $id)
    {
        return PropertyCategory::find($id);
    }

    public function update(array $data, string $id)
    {
        $category = $this->getPropertyCategoryById($id);
        $category->name = $data['name'];
        $category->icon = $data['icon'];
        $category->slug = $data['slug'];
        $category->save();

        return $category;
    }

    public function delete(string $id)
    {
        return $this->getPropertyCategoryById($id)->delete();
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
        if (PropertyCategory::count() === 0) {
            return true;
        }

        $query = PropertyCategory::where('slug', $slug);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->count() === 0;
    }
}
