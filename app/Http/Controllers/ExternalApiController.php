<?php

namespace App\Http\Controllers;

use App\Services\ExternalTaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExternalApiController extends Controller
{
    public function index(
        ExternalTaskService $service
    ): JsonResponse {
        $result = $service->getExternalTasks();

        return $this->respond($result);
    }

    public function show(
        ExternalTaskService $service,
        int $id
    ): JsonResponse {
        $result = $service->getExternalTaskById($id);

        return $this->respond($result);
    }

    public function store(
        Request $request,
        ExternalTaskService $service
    ): JsonResponse {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'completed' => 'required|boolean',
            'userId' => 'required|integer|min:1',
        ]);

        $result = $service->sendTaskData($data);

        return $this->respond($result);
    }

    private function respond(array $result): JsonResponse
    {
        if ($result['success']) {
            return response()->json([
                'data' => $result['data'],
            ], $result['status']);
        }

        return response()->json([
            'message' => $result['error'],
        ], $result['status']);
    }
}
