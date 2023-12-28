<?php

namespace App\DTO;

use App\Enum\OrderDirectionEnum;
use App\Enum\TaskStatusEnum;

class TaskListParams
{
    public ?TaskStatusEnum $statusFilter;
    public ?int $priorityFilter;
    public ?string $search;

    public array $orders;

    public function __construct(string $json)
    {
        $this->statusFilter = null;
        $this->priorityFilter = null;
        $this->search = null;
        $this->orders = [];


        $data = json_decode($json);
        if(empty($data)) {
            return;
        }

        $filters = $data->filters ?? null;
        if(!empty($filters)) {
            $this->statusFilter = TaskStatusEnum::tryFrom($filters->status ?? null);
            $this->priorityFilter = $filters->priority ?? null;
            $this->search = $filters->search ?? null;
        }
        $orders = $data->order ?? null;
        if(!empty($orders)) {
            foreach($orders as $column => $order) {
                $this->orders[$column] = (strtolower($order) == 'desc') ? 'desc' : 'asc';
            }
        }
    }
}
