<?php

namespace App\Interfaces;

interface FloorPlanRepositoryInterface
{
    public function getAllFloorPlans();

    public function getFloorPlanById(string $id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete(string $id);
}
