<?php

namespace App\Http\Controllers\API;

use App\Actions\Tasks\ShowTasksAction;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $tasks = (new ShowTasksAction)->handle($request);

        return $this->success($tasks);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return $this->success((new TaskResource($task->refresh())));
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status_changed_at'] = now();
        $task = $request->user()->tasks()->create($data);

        return $this->created(new TaskResource($task));
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return $this->success(new TaskResource($task));
    }
}
