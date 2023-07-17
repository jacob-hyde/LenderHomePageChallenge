<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskInProgressReminderNotification extends Notification
{
    use Queueable;

    /**
     * Task to remind about.
     *
     * @var Task
     */
    private Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task in progress reminder')
            ->line('Remind that the task has been in progress for more than 24 hours.')
            ->line('Task name: ' . $this->task->name)
            ->line('Task description: ' . $this->task->description)
            ->line('Task status: In progress')
            ->line('Task status changed at: ' . $this->task->status_changed_at->format('Y-m-d H:i:s'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
