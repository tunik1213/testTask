<?php

namespace App\Services;

use App\DTO\TaskDto;
use App\Enum\TaskStatusEnum;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(TaskDto $dto): Task
    {
        $task = new Task();
        $this->fillTaskFromDto($task, $dto);
        $task->save();

        return $task;
    }

    public function update(int $id, TaskDto $dto): Task
    {
        $task = $this->taskRepository->getTask($id);
        if(!$task->canEdit()) {
            abort(403);
        }

        $this->fillTaskFromDto($task, $dto);

        $task->save();

        return $task;
    }

    private function fillTaskFromDto(Task $task, TaskDto $dto): void
    {
        if($dto->status !== null) {
            $task->status = $dto->status;
        }
        if($dto->priority !== null) {
            $task->priority = $dto->priority;
        }
        if($dto->title !== null) {
            $task->title = $dto->title;
        }
        if($dto->description !== null) {
            $task->description = $dto->description;
        }
        if($dto->creator_id !== null) {
            $task->creator_id = $dto->creator_id;
        }
        if($dto->parent_id !== null) {
            $task->parent_id = $dto->parent_id;
        }
        if($dto->completed_at !== null) {
            $task->completed_at = $dto->completed_at;
        }
    }

    public function delete(int $id): void
    {
        $task = $this->taskRepository->getTask($id);
        if(!$task->canDelete()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $task->delete();
    }

    public function markDone($id): Task
    {
        $task = $this->taskRepository->getTask($id);
        if(!$task->canMarkDone()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $task->status = TaskStatusEnum::DONE;
        $task->completed_at = Carbon::now();
        $task->save();
        return $task;
    }
}
