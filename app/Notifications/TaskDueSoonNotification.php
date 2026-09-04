<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueSoonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Task $task) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task deadline approaching: '.$this->task->title)
            ->line('Your assigned task is approaching its deadline.')
            ->line('Deadline: '.$this->task->deadline?->format('Y-m-d H:i'))
            ->action('View Task', url('/admin/tasks/'.$this->task->id.'/edit'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_due_soon',
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'deadline' => $this->task->deadline?->toIso8601String(),
        ];
    }
}
