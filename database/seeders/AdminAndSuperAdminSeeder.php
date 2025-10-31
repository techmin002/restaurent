<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminAndSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Get all permission names
        $superadminPermissions = Permission::pluck('name')->toArray();

        // Create Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@bgrestrocare.com'],
            [
                'name' => 'Super Admin',
                'access_type' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);
        $superAdminRole->syncPermissions($superadminPermissions); // Assign all permissions

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@bgrestrocare.com'],
            [
                'name' => 'Admin User',
                'access_type' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);
        $adminRole->syncPermissions($superadminPermissions); // Assign all permissions
    }
}
