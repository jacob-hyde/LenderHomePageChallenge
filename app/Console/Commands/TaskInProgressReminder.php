<?php

namespace App\Console\Commands;

use App\Enum\TaskStatusEnum;
use App\Models\Task;
use App\Notifications\TaskInProgressReminderNotification;
use Illuminate\Console\Command;

class TaskInProgressReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-in-progress-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind that the task has been in progress for more than 24 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //We could add a check if the task has been in progress over 24 hours
        $tasks = Task::where('status', TaskStatusEnum::IN_PROGRESS)
            ->where('status_changed_at', '<=', now()->subHours(24))
            ->get();

        foreach ($tasks as $task) {
            $task->user->notify(new TaskInProgressReminderNotification($task));
        }
    }
}
