<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use App\Interfaces\AgentRepositoryInterface;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    private AgentRepositoryInterface $agentRepository;

    public function __construct(AgentRepositoryInterface $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $agents = $this->agentRepository->getAllAgents($request->search);

            return ResponseHelper::jsonResponse(true, 'Agents retrieved successfully', AgentResource::collection($agents), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgentRequest $request)
    {
        try {
            $agents = $this->agentRepository->createAgent($request->all());

            return ResponseHelper::jsonResponse(true, 'Agents created successfully', new AgentResource($agents), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $agent = $this->agentRepository->getAgentById($id);

            if (!$agent) {
                return ResponseHelper::jsonResponse(false, 'Agent not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Agent retrieved successfully', new AgentResource($agent), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgentRequest $request, string $id)
    {
        try {
            $this->agentRepository->updateAgent($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Agents updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->agentRepository->deleteAgent($id);

            return ResponseHelper::jsonResponse(true, 'Agents deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function getAgentBySlug(string $slug)
    {
        try {
            $agent = $this->agentRepository->getAgentBySlug($slug);

            if (!$agent) {
                return ResponseHelper::jsonResponse(false, 'Agent not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Agent retrieved successfully', new AgentResource($agent), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
