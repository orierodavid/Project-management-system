<?php

namespace App\Services;

use App\Models\Branch;

class GeofenceService
{
    public function distance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000;
        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($lngDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function distanceFromBranch(Branch $branch, float $latitude, float $longitude): float
    {
        return $this->distance(
            $latitude,
            $longitude,
            (float) $branch->latitude,
            (float) $branch->longitude,
        );
    }

    public function isWithinBranch(Branch $branch, float $latitude, float $longitude): bool
    {
        return $this->distanceFromBranch($branch, $latitude, $longitude)
            <= $branch->radius_meters;
    }
}
