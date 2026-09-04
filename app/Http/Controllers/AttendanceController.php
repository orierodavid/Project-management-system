<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\LateClockInNotification;
use App\Services\GeofenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        $record = $request->user()->attendanceRecords()
            ->with('branch')
            ->whereNull('clock_out_at')
            ->latest('clock_in_at')
            ->first();

        return response()->json([
            'clocked_in' => (bool) $record,
            'attendance' => $record,
        ]);
    }

    public function clockIn(Request $request, GeofenceService $geofence): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();
        abort_unless($user->isActive(), 403, 'Your account is suspended.');

        $result = DB::transaction(function () use ($user, $data, $geofence): array {
            $lockedUser = User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail();
            $branch = $lockedUser->primaryBranch;

            abort_unless($branch instanceof Branch && $branch->is_active, 422, 'You do not have an active primary branch assigned.');
            abort_if($branch->latitude == 0.0 && $branch->longitude == 0.0, 422, 'Your assigned branch has not been configured with valid GPS coordinates.');

            if ($lockedUser->attendanceRecords()->whereNull('clock_out_at')->exists()) {
                return ['already_clocked_in' => true];
            }

            $distance = $geofence->distanceFromBranch($branch, (float) $data['latitude'], (float) $data['longitude']);

            if ($distance > $branch->radius_meters) {
                return [
                    'outside_geofence' => true,
                    'distance' => $distance,
                    'radius' => $branch->radius_meters,
                ];
            }

            $settings = Setting::current();
            $now = Carbon::now($settings->timezone);
            $lateAfter = Carbon::parse($now->toDateString().' '.$settings->late_after_time, $settings->timezone);
            $lateMinutes = $now->greaterThan($lateAfter) ? $lateAfter->diffInMinutes($now) : 0;

            $record = $lockedUser->attendanceRecords()->create([
                'branch_id' => $branch->id,
                'clock_in_at' => $now,
                'clock_in_lat' => $data['latitude'],
                'clock_in_lng' => $data['longitude'],
                'clock_in_accuracy' => $data['accuracy'] ?? null,
                'clock_in_distance_meters' => $distance,
                'status' => $lateMinutes > 0 ? 'late' : 'on_time',
                'late_minutes' => $lateMinutes,
            ]);

            return ['record' => $record, 'late' => $lateMinutes > 0];
        });

        if (($result['already_clocked_in'] ?? false) === true) {
            return response()->json(['message' => 'You are already clocked in.'], 422);
        }

        if (($result['outside_geofence'] ?? false) === true) {
            return response()->json([
                'message' => 'Clock-in rejected. You are outside your assigned branch geofence.',
                'distance_meters' => round($result['distance'], 2),
                'allowed_radius_meters' => $result['radius'],
            ], 422);
        }

        $record = $result['record'];

        if ($result['late']) {
            $user->notify(new LateClockInNotification($record));
        }

        return response()->json(['message' => 'Clock-in successful.', 'attendance' => $record], 201);
    }

    public function clockOut(Request $request, GeofenceService $geofence): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();
        abort_unless($user->isActive(), 403, 'Your account is suspended.');

        $result = DB::transaction(function () use ($user, $data, $geofence): array {
            $lockedUser = User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail();
            $record = $lockedUser->attendanceRecords()
                ->whereNull('clock_out_at')
                ->latest('clock_in_at')
                ->first();

            if (! $record) {
                return ['missing' => true];
            }

            $branch = $record->branch;
            abort_unless($branch instanceof Branch, 422, 'The historical attendance branch could not be found.');
            abort_if($branch->latitude == 0.0 && $branch->longitude == 0.0, 422, 'The historical attendance branch has invalid GPS coordinates.');

            $distance = $geofence->distanceFromBranch($branch, (float) $data['latitude'], (float) $data['longitude']);

            if ($distance > $branch->radius_meters) {
                return [
                    'outside_geofence' => true,
                    'distance' => $distance,
                    'radius' => $branch->radius_meters,
                ];
            }

            $record->update([
                'clock_out_at' => Carbon::now(Setting::current()->timezone),
                'clock_out_lat' => $data['latitude'],
                'clock_out_lng' => $data['longitude'],
                'clock_out_accuracy' => $data['accuracy'] ?? null,
                'clock_out_distance_meters' => $distance,
            ]);

            return ['record' => $record->fresh()];
        });

        if (($result['missing'] ?? false) === true) {
            return response()->json(['message' => 'You do not have an open attendance session.'], 422);
        }

        if (($result['outside_geofence'] ?? false) === true) {
            return response()->json([
                'message' => 'Clock-out rejected. You are outside the historical attendance branch geofence.',
                'distance_meters' => round($result['distance'], 2),
                'allowed_radius_meters' => $result['radius'],
            ], 422);
        }

        return response()->json(['message' => 'Clock-out successful.', 'attendance' => $result['record']]);
    }
}
