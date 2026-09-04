<?php

namespace Tests\Feature;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AttendanceTest extends TestCase
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

    private function makeBranch(array $attributes = []): Branch
    {
        return Branch::query()->create(array_merge([
            'name' => 'Test Branch',
            'address' => 'Test Address',
            'latitude' => 6.5244000,
            'longitude' => 3.3792000,
            'radius_meters' => 200,
            'is_active' => true,
        ], $attributes));
    }

    protected function setUp(): void
    {
        parent::setUp();

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

    public function test_user_can_clock_in_inside_primary_branch_geofence(): void
    {
        $branch = $this->makeBranch();
        $user = $this->makeUser(['primary_branch_id' => $branch->id]);

        $response = $this->actingAs($user)->postJson(route('attendance.clock-in'), [
            'latitude' => 6.5244000,
            'longitude' => 3.3792000,
            'accuracy' => 10,
        ]);

        $response->assertOk()->assertJsonPath('success', true);
        $this->assertDatabaseHas('attendance_records', [
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'status' => 'on_time',
        ]);
    }

    public function test_clock_in_is_rejected_outside_geofence(): void
    {
        $branch = $this->makeBranch();
        $user = $this->makeUser(['primary_branch_id' => $branch->id]);

        $response = $this->actingAs($user)->postJson(route('attendance.clock-in'), [
            'latitude' => 6.6000000,
            'longitude' => 3.4500000,
            'accuracy' => 10,
        ]);

        $response->assertStatus(422)->assertJsonPath('success', false);
        $this->assertDatabaseCount('attendance_records', 0);
    }

    public function test_user_cannot_clock_in_twice_while_already_clocked_in(): void
    {
        $branch = $this->makeBranch();
        $user = $this->makeUser(['primary_branch_id' => $branch->id]);

        $payload = [
            'latitude' => 6.5244000,
            'longitude' => 3.3792000,
            'accuracy' => 10,
        ];

        $this->actingAs($user)->postJson(route('attendance.clock-in'), $payload)->assertOk();
        $this->actingAs($user)->postJson(route('attendance.clock-in'), $payload)
            ->assertStatus(409)
            ->assertJsonPath('success', false);

        $this->assertDatabaseCount('attendance_records', 1);
    }

    public function test_clock_out_uses_the_historical_branch_geofence(): void
    {
        $branch = $this->makeBranch();
        $user = $this->makeUser(['primary_branch_id' => $branch->id]);

        $this->actingAs($user)->postJson(route('attendance.clock-in'), [
            'latitude' => 6.5244000,
            'longitude' => 3.3792000,
            'accuracy' => 10,
        ])->assertOk();

        $branch->update(['is_active' => false]);

        $response = $this->actingAs($user)->postJson(route('attendance.clock-out'), [
            'latitude' => 6.5244000,
            'longitude' => 3.3792000,
            'accuracy' => 10,
        ]);

        $response->assertOk()->assertJsonPath('success', true);
        $this->assertNotNull(AttendanceRecord::query()->first()->clock_out_at);
    }
}
