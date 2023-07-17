<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enum\TaskStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'status_changed_at',
        'parent_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status_changed_at' => 'datetime',
        'status' => TaskStatusEnum::class,
    ];

    /**
     * User relationship.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function parentPivot()
    {
        return $this->belongsToMany(Task::class, 'task_hierarchy', 'task_id', 'task_parent_id');
    }

    public function allParents(int $taskId = null)
    {
        if ($taskId === null) {
            $taskId = $this->id;
        }

        $parents = Task::select('tasks.id', 'tasks.name')
            ->join('task_hierarchy', 'tasks.id', '=', 'task_hierarchy.parent_task_id')
            ->where('task_hierarchy.child_task_id', $taskId)
            ->get();

        return $parents;
    }

    public function allParentsCTE(int $taskId = null)
    {
        if ($taskId === null) {
            $taskId = $this->id;
        }

        return DB::statement('
            WITH RECURSIVE task_hierarchy AS (
                SELECT task_id, task_name, parent_id
                FROM tasks
                WHERE task_id = ' . $taskId . '

                UNION ALL

                SELECT t.task_id, t.task_name, t.parent_id
                FROM tasks t
                INNER JOIN task_hierarchy th ON t.task_id = th.parent_id
            )
            SELECT task_id, task_name, parent_id
            FROM task_hierarchy;
        ');
    }
}
