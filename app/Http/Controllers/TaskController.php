<?php

namespace App\Http\Controllers;

use App\DTO\TaskListParams;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\DTO\TaskDto;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    private TaskRepository $taskRepository;
    private TaskService $taskService;

    public function __construct(
        TaskRepository $taskRepository,
        TaskService    $taskService
    ) {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }

    public function index(Request $request): JsonResponse
    {
        $userID = auth('sanctum')->user()->id;
        $listParams = new TaskListParams($request->getContent());
        $tasks = $this->taskRepository->getList($userID, $listParams);

        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $taskDTO = TaskDto::createFromRequest($request);
        $task = $this->taskService->create($taskDTO);
        return response()->json($task, Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $taskDTO = TaskDto::createFromRequest($request);
        $task = $this->taskService->update($id, $taskDTO);
        return response()->json($task, Response::HTTP_ACCEPTED);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $task = $this->taskService->delete($id);
        return response()->json($id, Response::HTTP_NO_CONTENT);
    }

    public function markDone(Request $request, int $id): JsonResponse
    {
        $task = $this->taskService->markDone($id);
        return response()->json($task);
    }
}
