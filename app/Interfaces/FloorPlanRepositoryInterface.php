<?php

namespace App\Interfaces;

interface FloorPlanRepositoryInterface
{
    public function getAllFloorPlans();

    public function getFloorPlanById(string $id);

    public function createFloorPlan(array $data);

    public function updateFloorPlan(array $data, $id);

    public function deleteFloorPlan(string $id);
}
