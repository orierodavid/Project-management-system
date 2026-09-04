<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\Setting;
use App\Services\GeofenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request, GeofenceService $geofence): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();
        abort_unless($user->isActive(), 403, 'Your account is suspended.');

        $branch = $user->primaryBranch;
        abort_unless($branch instanceof Branch && $branch->is_active, 422, 'You do not have an active primary branch assigned.');

        if ($user->attendanceRecords()->whereNull('clock_out_at')->exists()) {
            return response()->json(['message' => 'You are already clocked in.'], 422);
        }

        $distance = $geofence->distanceFromBranch($branch, (float) $data['latitude'], (float) $data['longitude']);

        if ($distance > $branch->radius_meters) {
            return response()->json([
                'message' => 'Clock-in rejected. You are outside your assigned branch geofence.',
                'distance_meters' => round($distance, 2),
                'allowed_radius_meters' => $branch->radius_meters,
            ], 422);
        }

        $settings = Setting::current();
        $now = Carbon::now($settings->timezone);
        $lateAfter = Carbon::parse($now->toDateString().' '.$settings->late_after_time, $settings->timezone);
        $lateMinutes = $now->greaterThan($lateAfter) ? $lateAfter->diffInMinutes($now) : 0;

        $record = $user->attendanceRecords()->create([
            'branch_id' => $branch->id,
            'clock_in_at' => $now,
            'clock_in_lat' => $data['latitude'],
            'clock_in_lng' => $data['longitude'],
            'clock_in_accuracy' => $data['accuracy'] ?? null,
            'clock_in_distance_meters' => $distance,
            'status' => $lateMinutes > 0 ? 'late' : 'on_time',
            'late_minutes' => $lateMinutes,
        ]);

        return response()->json(['message' => 'Clock-in successful.', 'attendance' => $record], 201);
    }

    public function clockOut(Request $request, GeofenceService $geofence): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $record = $request->user()->attendanceRecords()->whereNull('clock_out_at')->latest('clock_in_at')->first();
        abort_unless($record, 422, 'You do not have an open attendance session.');

        $branch = $record->branch;
        $distance = $geofence->distanceFromBranch($branch, (float) $data['latitude'], (float) $data['longitude']);

        if ($distance > $branch->radius_meters) {
            return response()->json([
                'message' => 'Clock-out rejected. You are outside your assigned branch geofence.',
                'distance_meters' => round($distance, 2),
                'allowed_radius_meters' => $branch->radius_meters,
            ], 422);
        }

        $record->update([
            'clock_out_at' => Carbon::now(Setting::current()->timezone),
            'clock_out_lat' => $data['latitude'],
            'clock_out_lng' => $data['longitude'],
            'clock_out_accuracy' => $data['accuracy'] ?? null,
            'clock_out_distance_meters' => $distance,
        ]);

        return response()->json(['message' => 'Clock-out successful.', 'attendance' => $record->fresh()]);
    }
}
