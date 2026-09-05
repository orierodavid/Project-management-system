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
        $email = env('SUPER_ADMIN_EMAIL', 'admin@example.com');
        $password = env('SUPER_ADMIN_PASSWORD', 'ChangeMe123!');

        $user = User::query()->firstOrNew(['email' => $email]);
        $user->name = env('SUPER_ADMIN_NAME', 'System Administrator');
        $user->status = 'active';

        if ($password !== '') {
            $user->password = Hash::make($password);
        }

        if ($branch) {
            $user->primary_branch_id = $branch->id;
        }

        $user->save();

        if ($branch) {
            $user->branches()->syncWithoutDetaching([$branch->id]);
        }

        $user->syncRoles(['Super Admin']);
    }
}
