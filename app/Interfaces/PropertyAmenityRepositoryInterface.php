<?php

namespace App\Interfaces;

interface PropertyAmenityRepositoryInterface
{
    public function getAllPropertyAmenities();

    public function getPropertyAmenityById(string $id);

    public function create(array $data);

    public function update(array $data, string $id);

    public function delete(string $id);
}
