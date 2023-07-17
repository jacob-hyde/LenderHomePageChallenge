<?php

namespace App\Actions\Tasks;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class ShowTasksAction
{
    public function handle(Request $request)
    {
        $tasks = $request->user()->tasks();

        if ($request->query('status')) {
            $tasks->where('status', $request->query('status'));
        }

        return TaskResource::collection($tasks->get());
    }
}
