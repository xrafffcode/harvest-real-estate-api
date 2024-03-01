<?php

namespace App\Repositories;

use App\Interfaces\AgentRepositoryInterface;
use App\Models\Agent;
use Illuminate\Support\Str;

class AgentRepository implements AgentRepositoryInterface
{
    public function getAllAgents($search = null)
    {
        if ($search) {
            return Agent::where('name', 'like', '%'.$search.'%')->get();
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
        $agent = new Agent();
        $agent->slug = $data['slug'];
        $agent->code = $data['code'];
        $agent->name = $data['name'];
        $agent->description = $data['description'];
        $agent->specialization = $data['specialization'];
        $agent->email = $data['email'];
        $agent->phone_number = $data['phone_number'];
        $agent->facebook = $data['facebook'];
        $agent->twitter = $data['twitter'];
        $agent->instagram = $data['instagram'];
        $agent->linkedin = $data['linkedin'];
        $agent->avatar = $data['avatar']->store('assets/agents', 'public');
        $agent->save();

        return $agent;
    }

    public function updateAgent($data, $id)
    {
        $agent = Agent::find($id);
        $agent->slug = $data['slug'];
        $agent->code = $data['code'];
        $agent->name = $data['name'];
        $agent->description = $data['description'];
        $agent->specialization = $data['specialization'];
        $agent->email = $data['email'];
        $agent->phone_number = $data['phone_number'];
        $agent->facebook = $data['facebook'];
        $agent->twitter = $data['twitter'];
        $agent->instagram = $data['instagram'];
        $agent->linkedin = $data['linkedin'];
        $agent->avatar = $data['avatar']->store('assets/agents', 'public');
        $agent->save();

        return $agent;
    }

    public function deleteAgent($id)
    {
        return Agent::destroy($id);
    }

    public function generateCode(int $tryCount): string
    {
        $count = Agent::count() + $tryCount;
        $code = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, string $exceptId = null): bool
    {
        if (Agent::count() == 0) {
            return true;
        }

        $result = Agent::where('code', $code);

        if ($exceptId) {
            $result = $result->where('id', '!=', $exceptId);
        }

        return $result->count() == 0 ? true : false;
    }

    public function generateSlug(string $code, string $name, int $tryCount): string
    {
        $slug = Str::slug($name.'_'.$code);

        if ($tryCount > 0) {
            $slug = $slug.'_'.$tryCount;
        }

        return $slug;
    }

    public function isUniqueSlug(string $slug, string $exceptId = null): bool
    {
        if (Agent::count() === 0) {
            return true;
        }

        $query = Agent::where('slug', $slug);

        if ($exceptId) {
            $query = $query->where('id', '!=', $exceptId);
        }

        return $query->count() == 0 ? true : false;
    }
}
