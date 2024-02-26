<?php

namespace App\Repositories;

use App\Interfaces\FloorPlanRepositoryInterface;
use App\Models\FloorPlan;

class FloorPlanRepository implements FloorPlanRepositoryInterface
{
    public function getAllFloorPlans()
    {
        return FloorPlan::all();
    }

    public function getFloorPlanById($id)
    {
        return FloorPlan::find($id);
    }

    public function createFloorPlan($data)
    {
        return FloorPlan::create($data);
    }

    public function updateFloorPlan($data, $id)
    {
        return FloorPlan::find($id)->update($data);
    }

    public function deleteFloorPlan($id)
    {
        return FloorPlan::destroy($id);
    }
}
