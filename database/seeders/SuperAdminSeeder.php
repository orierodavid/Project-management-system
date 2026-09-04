<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::query()->first();

        $user = User::firstOrCreate(
            ['email' => env('SUPER_ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('SUPER_ADMIN_NAME', 'System Administrator'),
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'ChangeMe123!')),
                'primary_branch_id' => $branch?->id,
                'status' => 'active',
            ],
        );

        if ($branch) {
            $user->branches()->syncWithoutDetaching([$branch->id]);
        }

        $user->syncRoles(['Super Admin']);
    }
}
