<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Services\GeofenceService;
use PHPUnit\Framework\TestCase;

class GeofenceServiceTest extends TestCase
{
    public function test_location_inside_branch_radius_is_accepted(): void
    {
        $branch = new Branch([
            'latitude' => 6.5244,
            'longitude' => 3.3792,
            'radius_meters' => 500,
        ]);

        $service = new GeofenceService;

        $this->assertTrue($service->isWithinBranch($branch, 6.5248, 3.3795));
    }

    public function test_location_outside_branch_radius_is_rejected(): void
    {
        $branch = new Branch([
            'latitude' => 6.5244,
            'longitude' => 3.3792,
            'radius_meters' => 100,
        ]);

        $service = new GeofenceService;

        $this->assertFalse($service->isWithinBranch($branch, 6.5300, 3.3900));
    }
}
