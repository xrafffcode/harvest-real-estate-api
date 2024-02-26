<?php

namespace App\Interfaces;

interface PropertyTypeRepositoryInterface
{
    public function getAllPropertyTypes();

    public function createPropertyType(array $data);

    public function getPropertyTypeById(string $id);

    public function updatePropertyType(array $data, string $id);

    public function deletePropertyType(string $id);
}
