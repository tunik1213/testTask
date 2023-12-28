<?php

namespace App\Enum;

enum TaskStatusEnum: string
{
    case TODO = 'todo';
    case DONE = 'done';

    public function toString(): string
    {
        return $this->value;
    }

}
