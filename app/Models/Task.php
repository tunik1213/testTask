<?php

namespace App\Models;

use App\Enum\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User;
use PhpParser\Node\Expr\Cast\Bool_;

class Task extends Model
{
    use HasFactory;

    protected $hidden = [
        'updated_at',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => TaskStatusEnum::from($value),
            set: fn (TaskStatusEnum $value) => $value->value
        );
    }

    public function canEdit(): Bool
    {
        // a user can edit the task if it has been created by him
        $currentUserId = auth('sanctum')->user()->id ?? null;
        return ($this->creator_id == $currentUserId);
    }

    public function canDelete(): Bool
    {
        // a user can delete the task if it and it's children are editable by him
        if(!($this->canEdit() and $this->allChildrenCanEdit())) {
            return false;
        }

        // also task status and all its children statuses must be TODO
        if (($this->status == TaskStatusEnum::TODO) and $this->allChildrenHaveStatus(TaskStatusEnum::TODO)) {
            return true;
        } else {
            return false;
        }
    }

    public function allChildrenCanEdit(): Bool
    {
        foreach($this->children()->get() as $c) {
            if (!$c->canEdit()) {
                return false;
            }
            if(!$c->allChildrenCanEdit()) {
                return false;
            }
        }

        return true;
    }

    public function allChildrenHaveStatus(TaskStatusEnum $status): Bool
    {
        foreach($this->children()->get() as $c) {
            if($c->status != $status) {
                return false;
            }
            if(!$c->allChildrenHaveStatus($status)) {
                return false;
            }
        }

        return true;
    }

    public function canMarkDone(): Bool
    {
        // a user can mark task as done if it is editable
        if(!$this->canEdit()) {
            return false;
        }

        // and all its children statuses must be DONE
        if($this->allChildrenHaveStatus(TaskStatusEnum::DONE)) {
            return true;
        } else {
            return false;
        }
    }
}
