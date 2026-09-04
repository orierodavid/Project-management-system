<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskEventNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TaskAutomationTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(array $attributes = []): User
    {
        return User::query()->create(array_merge([
            'name' => 'Test User',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'status' => 'active',
        ], $attributes));
    }

    private function makeTask(User $assignee, array $attributes = []): Task
    {
        return Task::query()->create(array_merge([
            'title' => 'Test task',
            'assigned_to' => $assignee->id,
            'assigned_by' => $assignee->id,
            'priority' => 'medium',
            'status' => 'todo',
            'is_overdue' => false,
            'deadline' => Carbon::now()->addHours(2),
        ], $attributes));
    }

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::create(2026, 1, 1, 8, 0, 0, 'Africa/Lagos')
        );

        Setting::query()->create([
            'company_name' => 'Test Company',
            'primary_color' => '#2563EB',
            'secondary_color' => '#0F172A',
            'timezone' => 'Africa/Lagos',
            'work_start_time' => '08:00:00',
            'late_after_time' => '08:15:00',
            'work_end_time' => '17:00:00',
            'task_due_soon_hours' => 24,
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_due_soon_command_uses_configured_window_and_notifies_assignee(): void
    {
        Notification::fake();
        Setting::current()->update(['task_due_soon_hours' => 4]);

        $user = $this->makeUser();
        $inside = $this->makeTask($user, ['deadline' => Carbon::now()->addHours(3)]);
        $outside = $this->makeTask($user, ['deadline' => Carbon::now()->addHours(5)]);

        $this->artisan('tasks:check-due-soon')->assertSuccessful();

        Notification::assertSentTo($user, TaskEventNotification::class, function ($notification) use ($inside): bool {
            return $notification->task->is($inside) && $notification->title === 'Task due soon';
        });

        Notification::assertNotSentTo($user, function ($notification) use ($outside): bool {
            return $notification instanceof TaskEventNotification && $notification->task->is($outside);
        });
    }

    public function test_due_soon_command_does_not_duplicate_recent_notification(): void
    {
        Notification::fake();
        $user = $this->makeUser();
        $task = $this->makeTask($user, ['deadline' => Carbon::now()->addHours(2)]);

        $this->artisan('tasks:check-due-soon')->assertSuccessful();
        Notification::assertSentToTimes($user, TaskEventNotification::class, 1);

        Notification::fake();
        $this->artisan('tasks:check-due-soon')->assertSuccessful();
        Notification::assertNothingSent();

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $user->id,
            'type' => TaskEventNotification::class,
        ]);

        $this->assertTrue($task->exists);
    }

    public function test_overdue_command_marks_only_open_past_deadline_tasks_and_notifies(): void
    {
        Notification::fake();
        $user = $this->makeUser();
        $overdue = $this->makeTask($user, [
            'deadline' => Carbon::now()->subMinute(),
        ]);
        $done = $this->makeTask($user, [
            'status' => 'done',
            'deadline' => Carbon::now()->subMinute(),
        ]);

        $this->artisan('tasks:check-overdue')->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'id' => $overdue->id,
            'is_overdue' => true,
        ]);
        $this->assertDatabaseHas('tasks', [
            'id' => $done->id,
            'is_overdue' => false,
        ]);

        Notification::assertSentTo($user, TaskEventNotification::class, function ($notification) use ($overdue): bool {
            return $notification->task->is($overdue) && $notification->title === 'Task overdue';
        });
    }
}
