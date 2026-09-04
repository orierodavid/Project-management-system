<?php

namespace App\Notifications;

use App\Models\AttendanceRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LateClockInNotification extends Notification
{
    use Queueable;

    public function __construct(public AttendanceRecord $attendance) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Late clock-in recorded')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Your attendance has been recorded as late.')
            ->line('Late by: '.$this->attendance->late_minutes.' minutes.')
            ->line('Clock-in: '.$this->attendance->clock_in_at->format('d M Y, H:i'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'attendance_id' => $this->attendance->id,
            'title' => 'Late clock-in',
            'message' => 'You clocked in '.$this->attendance->late_minutes.' minutes late.',
        ];
    }
}
