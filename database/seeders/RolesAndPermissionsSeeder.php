<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-settings',
            'manage-branches',
            'manage-admins',
            'manage-users',
            'manage-departments',
            'manage-tasks',
            'view-all-attendance',
            'view-reports',
            'manage-staff',
            'view-scoped-attendance',
            'view-assigned-tasks',
            'update-own-tasks',
            'comment-on-tasks',
            'upload-task-attachments',
            'clock-in',
            'clock-out',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        $admin = Role::findOrCreate('Admin', 'web');
        $staff = Role::findOrCreate('Staff', 'web');

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'manage-staff',
            'manage-users',
            'manage-departments',
            'manage-tasks',
            'view-scoped-attendance',
            'view-reports',
        ]);

        $staff->syncPermissions([
            'view-assigned-tasks',
            'update-own-tasks',
            'comment-on-tasks',
            'upload-task-attachments',
            'clock-in',
            'clock-out',
        ]);
    }
}
