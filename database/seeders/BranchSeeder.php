<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::firstOrCreate(
            ['name' => 'Head Office'],
            [
                'address' => 'Configure your company head office address',
                'latitude' => 0,
                'longitude' => 0,
                'radius_meters' => 100,
                'is_active' => false,
            ],
        );
    }
}
