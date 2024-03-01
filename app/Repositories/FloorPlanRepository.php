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

    public function create($data)
    {
        $floorPlan = new FloorPlan;
        $floorPlan->property_id = $data['property_id'];
        $floorPlan->sort = $data['sort'];
        $floorPlan->title = $data['title'];
        $floorPlan->image = $data['image']->store('assets/floor-plans', 'public');
        $floorPlan->save();

        return $floorPlan;
    }

    public function update($data, $id)
    {
        $floorPlan = FloorPlan::find($id);
        $floorPlan->property_id = $data['property_id'];
        $floorPlan->sort = $data['sort'];
        $floorPlan->title = $data['title'];
        $floorPlan->image = $data['image']->store('assets/floor-plans', 'public');
        $floorPlan->save();

        return $floorPlan;
    }

    public function delete($id)
    {
        return FloorPlan::destroy($id);
    }
}
