<?php

namespace App\Repositories;

use App\Interfaces\AgentRepositoryInterface;
use App\Models\Agent;

class AgentRepository implements AgentRepositoryInterface
{
    public function getAllAgents($search = null)
    {
        if ($search) {
            return Agent::where('name', 'like', '%' . $search . '%')->get();
        }

        return Agent::all();
    }

    public function getAgentBySlug($slug)
    {
        return Agent::where('slug', $slug)->first();
    }

    public function getAgentById($id)
    {
        return Agent::find($id);
    }

    public function createAgent($data)
    {
        return Agent::create($data);
    }

    public function updateAgent($data, $id)
    {
        return Agent::findOrfail($id)->update($data);
    }

    public function deleteAgent($id)
    {
        return Agent::destroy($id);
    }
}
