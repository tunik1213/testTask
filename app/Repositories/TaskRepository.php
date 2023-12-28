<?php

namespace App\Repositories;

use App\DTO\TaskListParams;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function getList(int $userId, TaskListParams $params): Collection
    {
        $query = Task::where(["creator_id" => $userId]);

        if($params->priorityFilter) {
            $query->where('priority', $params->priorityFilter);
        }

        if($params->statusFilter) {
            $query->where('status', $params->statusFilter);
        }

        if($params->search) {
            $query->whereFullText(['title','description'], $params->search, );
        }

        foreach($params->orders as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query->get();
    }

    public function getTask(int $id): Task
    {
        return Task::findOrFail($id);
    }

}
