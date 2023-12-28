<?php

namespace App\DTO;

use Illuminate\Http\Request;
use App\Enum\TaskStatusEnum;

class TaskDto
{
    public readonly ?TaskStatusEnum $status;
    public readonly ?int $priority;
    public readonly ?string $title;
    public readonly ?string $description;
    public readonly ?int $creator_id;
    public readonly ?int $parent_id;
    public readonly ?date $completed_at;

    public static function createFromRequest(Request $request): TaskDto
    {
        $creation = ($request->isMethod('post'));
        $request->validate(self::validationRules($creation));

        $taskDto = new TaskDto();
        $taskDto->status = TaskStatusEnum::from($request->input('status'));
        $taskDto->priority = $request->input('priority');
        $taskDto->title = $request->input('title');
        $taskDto->description = $request->input('description');
        $taskDto->creator_id = auth('sanctum')->user()->id;
        $taskDto->parent_id = $request->input('parent_id');
        $taskDto->completed_at = $request->input('completed_at');
        return $taskDto;
    }

    public static function validationRules(Bool $creation): array
    {
        $required = ($creation) ? 'required|' : '';
        return [
            'title' => $required.'min:3',
            'priority' => $required.'integer|between:1,5',
        ];
    }
}
