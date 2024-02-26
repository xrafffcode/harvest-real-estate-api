<?php

namespace App\Interfaces;

interface AgentRepositoryInterface
{
    public function getAllAgents(string $search = null);

    public function getAgentBySlug(string $slug);

    public function getAgentById(string $id);

    public function createAgent(array $data);

    public function updateAgent(array $data, string $id);

    public function deleteAgent(string $id);
}
