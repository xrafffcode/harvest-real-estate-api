<?php

namespace App\Interfaces;

interface PropertyCategoryRepositoryInterface
{
    public function getAllPropertyCategories();

    public function createPropertyCategory(array $data);

    public function getPropertyCategoryById(string $id);

    public function updatePropertyCategory(array $data, string $id);

    public function deletePropertyCategory(string $id);
}
