<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskEventNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Task $task,
        public string $event,
        public string $message,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->event.': '.$this->task->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->message)
            ->line('Task: '.$this->task->title)
            ->line('Priority: '.ucfirst($this->task->priority))
            ->line('Deadline: '.($this->task->deadline?->format('d M Y, H:i') ?? 'No deadline'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'event' => $this->event,
            'title' => $this->event,
            'message' => $this->message,
        ];
    }
}
